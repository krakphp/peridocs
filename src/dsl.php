<?php

use Peridot\{Core\Suite, Runner\Context};
use Krak\Peridocs\{DocDefinition, DocsContext};

function docFn(string $name) {
    $suite = Context::getInstance()->getCurrentSuite();
    DocsContext::getInstance()->addDocFn($suite, $name);
}

/** add aliases for `it` */
function test(string $desc, Closure $definition = null) {
    return it($desc, $definition);
}
function xtest(string $desc, Closure $definition = null) {
    return xit($desc, $definition);
}
function ftest(string $desc, Closure $definition = null) {
    return fit($desc, $definition);
}

function docIntro(string $intro) {
    $suite = Context::getInstance()->getCurrentSuite();
    DocsContext::getInstance()->setDocIntro($suite, $intro);
}

function docOutro(string $outro) {
    $suite = Context::getInstance()->getCurrentSuite();
    DocsContext::getInstance()->setDocOutro($suite, $outro);
}
