<?php

namespace Krak\Peridocs;

function testFn($a, $b, ...$args): string {
    return 'foo';
}

describe('Peridocs', function() {
    describe('FunctionParser', function() {
        beforeEach(function() {
            $this->fp = FunctionParser::create();
        });
        it('can parse a function signature', function() {
            $res = $this->fp->parseFunctionSignature(testFn::class);
            expect($res)->equal('testFn($a, $b, ...$args): string');
        });
        it('can parse a closure\'s statements', function() {
            $res = $this->fp->parseClosureStatements(function() {
                $a = 1;
                $b = 2;
            });
            expect($res)->equal("\$a = 1;\n\$b = 2;");
        });
    });
});
