<?php

use Peridot\{Core\Suite, Runner\Context};
use Krak\Peridocs\{DocDefinition, DocsContext};

function docFn(string $name) {
    $suite = Context::getInstance()->getCurrentSuite();
    DocsContext::getInstance()->addDocFn($suite, $name);
}


function docIntro(string $intro) {
    $suite = Context::getInstance()->getCurrentSuite();
    DocsContext::getInstance()->setDocIntro($suite, $intro);
}

function docOutro(string $outro) {
    $suite = Context::getInstance()->getCurrentSuite();
    DocsContext::getInstance()->setDocOutro($suite, $outro);
}
