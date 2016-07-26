grammar Simple;

@header{
    import java.util.*;
    import org.antlr.v4.runtime.*;
}

@members{
    SymbolTable sym = new SymbolTable();
}

start : prog{
                System.out.println($prog.code);

                System.out.println("    return");   
                System.out.println(".end method");
            }EOF;

prog returns [Code code]
    @init { $code = Code.empty(); }
    : (stmt{
        $code.addAll($stmt.code);
    })+;

expr returns [Code code]
    @init { $code = Code.empty(); }
    : e1=expr OP e2=expr{
        $code = new Code();
        $code.addAll($e1.code);
        $code.addAll($e2.code);
        $code.add(Instruction.Op($OP.text));
    }
    | '('e1 = expr')'{
        $code = new Code();
        $code.addAll($e1.code);
    }
    | ID{
        if(this.sym.containsKey($ID.text)) {
            $code.add(Instruction.ILOAD(this.sym.get($ID.text)));
        } else {
            $code.add(Instruction.LDC(0));
        }

    }
    | NUM{
        $code.add(Instruction.LDC($NUM.text));

    }
    ;

repeatStmt returns[Code code]
    : 'repeat' expr '{' prog '}'
        {   
            $code = new Code();
            String start = Code.newLabel();
            String end   = Code.newLabel();
            int register = this.sym.resolve("TMP");
            $code.addAll($expr.code);
            $code.add(Instruction.ISTORE(this.sym.get("TMP")));
            $code.add(Instruction.Label(start));
            $code.add(Instruction.ILOAD(register));
            $code.add(Instruction.IFZERO(end));
            $code.add(Instruction.ILOAD(this.sym.get("TMP")));
            $code.add(Instruction.LDC(1));
            $code.add(Instruction.Op("-"));
            $code.add(Instruction.ISTORE(this.sym.get("TMP")));
            $code.addAll($prog.code);
            $code.add(Instruction.GOTO(start));
            $code.add(Instruction.Label(end));
        }
    ;

stmt returns[Code code]
    @init {$code = Code.empty();}
    : assignStmt     {$code = $assignStmt.code;}
    | printStmt      {$code = $printStmt.code;}
    | repeatStmt      {$code = $repeatStmt.code;}
    ;

printStmt returns[Code code] 
    : 'print' '(' exprList ')'{
        $code = new Code();
        $code.addAll($exprList.code);
    }
    ;

exprList returns [Code code]
    @init {$code = Code.empty();}
    : (e1=expr ',' 
    {   $code.add(Instruction.getPrintStream());
        $code.addAll($e1.code);
        $code.add(Instruction.invokePrint());
        $code.add(Instruction.getPrintStream());
        $code.add(Instruction.LDC("\" \""));
        $code.add(Instruction.invokePrintString()); 
    })* e2=expr 
    {
        $code.add(Instruction.getPrintStream());
        $code.addAll($e2.code);
        $code.add(Instruction.invokePrintln()); 
    }
    ;

assignStmt returns [Code code]
    @init {$code = Code.empty();}
    : 'let' ID '=' expr
      { 

        int register = this.sym.resolve($ID.text);
        $code.addAll($expr.code);
        $code.add(Instruction.ISTORE(register));

      }
    ;

NUM : ('0' .. '9')+ ;
ID : ('a' .. 'z' | 'A' .. 'Z')+ ('a' .. 'z' | 'A' .. 'Z' | '0' .. '9' | '_' | '-')* ;
WS : (' ' | '\t' | '\r' | '\n') {skip();} ;
OP : '+' | '-' | '*' | '/';