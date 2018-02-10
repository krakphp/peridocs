<?php

namespace Krak\Peridocs;

use PhpParser\{
    Parser,
    ParserFactory,
    Node,
    Node\Stmt,
    PrettyPrinter,
    NodeTraverser,
    NodeVisitorAbstract
};
use ReflectionFunction;

final class FunctionParser
{
    private $parser;
    private $pp;

    public function __construct(Parser $parser) {
        $this->parser = $parser;
        $this->pp = new PrettyPrinter\Standard();
    }

    public static function create() {
        return new self((new ParserFactory)->create(ParserFactory::PREFER_PHP7));
    }

    public function parseFunctionSignature($name) {
        $rf = new ReflectionFunction($name);
        $code = $this->getCodeToParseFromReflectionFunction($rf);
        $ast = $this->parser->parse('<?php ' . $code);

        $fnStmt = $ast[0] ?? null;
        if (!$fnStmt || !$fnStmt instanceof Stmt\Function_) {
            throw new \RuntimeException('Expected first statement to be a function.' . "\n\n" . $code);
        }

        $fnStmt->stmts = [];
        $def = substr($this->pp->prettyPrint([$fnStmt]), 0, -4);
        $def = str_replace(' : ', ': ', $def);
        $def = str_replace('function ', '', $def);
        return $def;
    }

    public function parseClosureStatements(\Closure $closure) {
        $rf = new ReflectionFunction($closure);
        $code = $this->getCodeToParseFromReflectionFunction($rf);
        $ast = $this->parser->parse('<?php ' . $code);
        $closureDef = $this->findFirstClosureDefinition($ast);
        if (!$closureDef) {
            throw new \RuntimeException('Expected to find a closure definition.');
        }

        return $this->pp->prettyPrint($closureDef->stmts);
    }

    private function getCodeToParseFromReflectionFunction(ReflectionFunction $rf) {
        $fileLines = file($rf->getFileName());

        $linesToParse = array_slice($fileLines, $rf->getStartLine() - 1, $rf->getEndLine() - $rf->getStartLine() + 1);
        return implode($linesToParse);
    }

    private function findFirstClosureDefinition(array $ast) {
        $traverser = new NodeTraverser();
        $visitor = new class extends NodeVisitorAbstract {
            public $firstClosure;
            public function enterNode(Node $node) {
                if ($this->firstClosure) { return; }
                if ($node instanceof Node\Expr\Closure) {

                    $this->firstClosure = $node;
                }
            }
        };
        $traverser->addVisitor($visitor);
        $traverser->traverse($ast);
        return $visitor->firstClosure;
    }
}

