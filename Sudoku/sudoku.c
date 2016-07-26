#define _XOPEN_SOURCE 700
#include <stdlib.h>
#include <stdio.h>
#include "solver.h"
#include "validate.h"
int main()
{
	int puzzle[9][9];
	int choice = 0;
	FILE *f = fopen("puzzle.txt","r");
	for(int i = 0; i < 9; i++)
	{
		for(int j = 0; j < 9; j++)
		{
			fscanf(f,"%d", &puzzle[i][j]);
		}
	}
	printf("Enter 1 for validator enter 2 for solver (note the file that the puzzle will be taken from is puzzle.txt): ");
	scanf("%d",&choice);
	if(choice == 1)
		validate(puzzle);
	else
		solve(puzzle);
		printf("\n");
	for(int i = 0; i < 9; i++)
	{
		for(int j = 0; j < 9; j++)
		{
			printf("%d ", puzzle[i][j]);
		}
				printf("\n");
	}


}