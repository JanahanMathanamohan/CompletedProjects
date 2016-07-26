package algorithms;

import org.gamelink.game.Cram;
import org.gamelink.game.Algo;
import java.util.ArrayList;
import java.util.Date;

public class teamJA extends Algo { // Replace TeamName]
	int bwidth = 0;
	int blength = 0;
	ArrayList<Integer> nodes[];
	int numNodes;
	int availblocks = 0;
	int flags[];
	static int thresh;
	static long time;
	static boolean printed = false;

	public teamJA(int boardLength, int boardWidth) {
		bwidth = boardWidth;
		blength = boardLength;
		numNodes = boardWidth * boardLength;
		nodes = new ArrayList[numNodes];
		for (int i = 0; i < numNodes; i++) {
			nodes[i] = new ArrayList<>();
		}
		int count = 0;
		while (count < numNodes) {
			if (!(count % bwidth == bwidth - 1)) {
				addNode(count, count + 1);
				availblocks++;
			}
			if (count < numNodes - bwidth) {
				addNode(count, count + bwidth);
				availblocks++;
			}
			count++;
		}
		count = 0;
	}

	public void addNode(int parent, int addition) {
		nodes[parent].add(addition);
	}

	public void displayGraph() {
		for (int i = 0; i < numNodes; i++) {
			System.out.print(i + " ");
			for (int j : nodes[i]) {
				System.out.print(j + " ");
			}
			System.out.println(" ");
		}
	}

	public void removeNode(int parent) {
		availblocks = availblocks - nodes[parent].size();
		nodes[parent] = new ArrayList<Integer>();
		int up = parent - bwidth;
		int left = parent - 1;
		if (up >= 0) {
			for (int i = 0; i < nodes[up].size(); i++) {
				if (nodes[up].get(i) == parent) {
					nodes[up].remove(i);
					availblocks--;
				}
			}
		}
		if (parent % bwidth != 0) {
			for (int i = 0; i < nodes[left].size(); i++) {
				if (nodes[left].get(i) == parent) {
					nodes[left].remove(i);
					availblocks--;
				}
			}
		}
	}

	public String conversion(int node1, int node2) {
		String block1 = Integer.toString(node1 / bwidth) + Integer.toString(node1 % bwidth);
		String block2 = Integer.toString(node2 / bwidth) + Integer.toString(node2 % bwidth);
		String s = block1 + block2;

		return s;
	}

	public teamJA removeBlock(int node1, int node2) {
		removeNode(node1);
		removeNode(node2);
		return this;

	}

	public int[][] availPlacements() {
		int avail[][] = new int[availblocks][2];
		int count = 0;
		for (int i = 0; i < flags.length; i++) {
			for (int j = 0; j < nodes[flags[i]].size(); j++) {
				avail[count][0] = flags[i];
				avail[count][1] = nodes[flags[i]].get(j);
				count++;
				// System.out.println();
			}

		}
		return avail;

	}

	public void clone(teamJA g) {
		this.bwidth = g.bwidth;
		this.blength = g.blength;
		this.availblocks = g.availblocks;
		this.flags = g.flags;
		this.numNodes = g.numNodes;
		this.nodes = new ArrayList[this.numNodes];
		for (int i = 0; i < g.numNodes; i++) {
			this.nodes[i] = (ArrayList<Integer>) g.nodes[i].clone();
		}

	}

	private static String teamName = "teamJA"; // Replace TeamName
	static int prop[][];
	static int counter = 0;

	public static String getTeamName() {
		return teamName;
	}

	public static void main(String[] args) {
		Cram game = new Cram(false);
		game.startGame(teamJA.class); // Replace TeamName
	}

	public static String algorithm(Cram game) {
		time = System.currentTimeMillis();

		int board[][] = game.getBoard();
		teamJA g = new teamJA(board.length, board[0].length);
		ArrayList<Integer> flag = new ArrayList<Integer>();
		int index = 0;
		int numofones = 0;
		int numoftwoes = 0;
		for (int i = 0; i < board.length; i++) {
			for (int j = 0; j < board[i].length; j++) {
				index = j + i * board[0].length;
				if (board[i][j] == 99) {
					g.removeNode(index);
				} else if (board[i][j] == 1) {
					numofones++;
					g.removeNode(index);
				} else if (board[i][j] == 2) {
					numoftwoes++;
					g.removeNode(index);
				} else {
					flag.add(index);
				}
			}
		}
		int flags[] = new int[flag.size()];
		for (int i = 0; i < flag.size(); i++) {
			flags[i] = flag.get(i);
		}

		// int nodesH = board.length;
		// int nodesW = board[0].length;

		int nodesHW = board.length * board[0].length;

		if (nodesHW == 100) {
			// thresh = 10;
			thresh = 24;
		} else if (nodesHW <= 36) {
			thresh = 20;
		} else if (nodesHW >= 50) {
			thresh = 15;
		}
		System.out.println("THRESHOLD SET AT: " + thresh);
		g.flags = flags;
		int blocks[][];
		double max = 0;
		int position = 0;
		blocks = g.availPlacements();
		if (g.availblocks < thresh) {
			prop = new int[g.availblocks][2];
			max = 0;
			position = 0;
			for (int i = 0; i < g.availblocks; i++) {
				prop[i][0] = 0;
				prop[i][1] = 0;
			}
			counter = 0;
			recursive(g, 0);
			System.out.println("Calculating WRs... ");
			for (int i = 0; i < g.availblocks; i++) {
				double winrate = ((double) prop[i][1] / prop[i][0]) * 100;
				if (Double.isNaN(winrate)) {
					System.out.println("WARNING: WR IS UNKNOWN, SELECTING BEST CASE... ");
				} else {
					System.out.println(winrate + "% WR");
				}
				if (max < (double) prop[i][1] / prop[i][0]) {
					position = i;
					max = (double) prop[i][1] / prop[i][0];

				}
			}

			System.out.println("Route selected: " + max * 100 + "%");

			printed = false;
			g.removeBlock(blocks[position][0], blocks[position][1]);
			return g.conversion(blocks[position][0], blocks[position][1]);
		} else {

			if (numofones == numoftwoes) {
				int a[] = blockofmost(g);
				return g.conversion(a[0], a[1]);
			} else {
				int a[] = blockofLeast(g);
				return g.conversion(a[0], a[1]);
			}
		}
	}

	public static int recursive(teamJA ga, int turn) {
		if (printed != true) {
			if (ga.availblocks == 0) {
				if (turn % 2 == 0) {
					prop[counter][0]++;

				} else {
					prop[counter][0]++;
					prop[counter][1]++;
				}
				return 0;
			}
			teamJA g = new teamJA(1, 1);
			g.clone(ga);
			int blocks[][] = g.availPlacements();
			for (int i = 0; i < blocks.length; i++) {

				recursive(g.removeBlock(blocks[i][0], blocks[i][1]), turn + 1);

				if (System.currentTimeMillis() > time + 25000 && printed == false) {
					System.out.println("25 SECOND WARNING, ABORTING PATHFINDING");
					System.out.println("Initializing failsafes... standby...");
					printed = true;
				}

				if (turn == 0) {
					System.out.println("MOVE FOUND, stored: " + blocks.length + " " + counter);
					counter++;
				}
				g.clone(ga);
			}
		}
		return 1;
	}

	public static int[] blockofmost(teamJA ga) {
		teamJA g = new teamJA(1, 1);
		g.clone(ga);
		int location = 0;
		int least = 1000000;
		int blocks[][] = g.availPlacements();
		for (int i = 0; i < blocks.length; i++) {
			g = g.removeBlock(blocks[i][0], blocks[i][1]);
			if (least > g.availblocks) {

				least = g.availblocks;

				location = i;
			}
			g.clone(ga);
		}
		return blocks[location];
	}

	public static int[] blockofLeast(teamJA ga) {
		teamJA g = new teamJA(1, 1);
		g.clone(ga);
		int location = 0;
		int least = 0;
		int blocks[][] = g.availPlacements();
		for (int i = 0; i < blocks.length; i++) {

			g = g.removeBlock(blocks[i][0], blocks[i][1]);
			if (least < g.availblocks) {

				least = g.availblocks;
				location = i;
			}
			g.clone(ga);
		}
		return blocks[location];
	}
}