import java.util.*;
import java.io.*;
import org.antlr.v4.runtime.*;

public class SimpleCompiler {
	SymbolTable sym = new SymbolTable();

    public static void main(String[] args) throws Exception {
        
    	FileReader scan = new FileReader(args[0]); 
        ANTLRInputStream input = new ANTLRInputStream(scan);
        SimpleLexer lexer = new SimpleLexer(input);
        CommonTokenStream tokens = new CommonTokenStream(lexer);
        SimpleParser parser = new SimpleParser(tokens);
        
        String classes = args[0];
        int end = classes.indexOf(".");
        classes = classes.substring(9,classes.length()-4);
        System.out.println(".class public MyApp");
        System.out.println(".super java/lang/Object");
		System.out.println(".method public <init>()V");
		System.out.println("	aload_0");
		System.out.println("	invokenonvirtual java/lang/Object/<init>()V");
		System.out.println("	return");
		System.out.println(".end method");
		System.out.println(".method public static main([Ljava/lang/String;)V");
		System.out.println("	.limit stack 10");
		System.out.println("	.limit locals 10");
        parser.start();
    }
}

class Instruction {
    String label;
    String op;
    String x;
    String y;

    public Instruction(String label, String op, String x, String y) {
        this.label = label;
        this.op = op;
        this.x = x;
        this.y = y;
    }

    public static Instruction ISTORE(int register) {
        return new Instruction("", "istore", "" + register, "");
    }

    public static Instruction IADD() {
        return new Instruction("", "iadd", "", "");
    }

    public static Instruction getPrintStream() {
        return new Instruction(
                        "", 
                        "getstatic",
                        "java/lang/System/out",
                        "Ljava/io/PrintStream;");
    }
    public static Instruction invokePrintln() {
        return new Instruction(
                    "",
                    "invokevirtual",
                    "java/io/PrintStream/println(I)V",
                    "");
    }
    public static Instruction invokePrint() {
        return new Instruction(
                    "",
                    "invokevirtual",
                    "java/io/PrintStream/print(I)V",
                    "");
    }
    public static Instruction invokePrintString() {
         return new Instruction(
                    "",
                    "invokevirtual",
                    "java/io/PrintStream/print(Ljava/lang/String;)V",
                    "");
    }        
    public static Instruction Label(String label) {
        return new Instruction(label, "", "", "");
    }
    public static Instruction IFZERO(String label) {
        return new Instruction("", "ifeq", label, "");
    }
    public static Instruction GOTO(String label) {
        return new Instruction("", "goto", label, "");
    }
    public static Instruction ILOAD(int reg) {
        return new Instruction("", "iload", "" + reg, "");
    }
    public static Instruction LDC(int val) {
        return new Instruction("", "ldc", "" + val, "");
    }
    public static Instruction LDC(String val) {
        return new Instruction("", "ldc", "" + val, "");
    }
    public static Instruction Op(String x) {
        String op = "iadd";
        if(x.equals("+")) op = "iadd";
        if(x.equals("-")) op = "isub";
        if(x.equals("*")) op = "imul";
        if(x.equals("/")) op = "idiv";
        return new Instruction("", op, "", "");
    }
}

class Code extends Vector<Instruction> {
    static int labelCount = 0;
    public Code() {
        super();
    }

    public static Code empty() {
        return new Code();
    }
    public static String newLabel() {
        String label = "LABEL" + labelCount;
        labelCount += 1;
        return label;
    }
    @Override
    public String toString() {
        String out = "";
        for(Instruction i : this) {
            if(! i.label.equals("")) {
                out += i.label + ": ";
            }
            out += i.op + " " + i.x + " " + i.y + "\n";
        }
        return out;
    }
}

class SymbolTable extends TreeMap<String, Integer> {
    static int registerCount = 0;

    public SymbolTable() {
        super();
    }

    public int resolve(String varname) {
        if(! this.containsKey(varname)) {
            int register = SymbolTable.registerCount;
            SymbolTable.registerCount += 1;
            this.put(varname, register);
        }

        return this.get(varname);
    }
}
