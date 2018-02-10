<?php

namespace Krak\Peridocs;

function bootstrap($emitter) {
    $emitter->on('peridot.start', function() {
        require_once __DIR__ . '/dsl.php';
    });
    $emitter->on('test.passed', function($test) {
        DocsContext::getInstance()->addDocFeature($test);
    });
    $emitter->on('peridot.reporters', function($input, $reporters) {
        $reporters->register('peridocs', 'Generate markdown documentation from tests!', function($reporter) {
            $output = $reporter->getOutput();

            $reporter->getEventEmitter()->on('runner.end', function() use ($output) {
                $output->writeln(DocsContext::getInstance()->formatDocs());
            });
        });
    });
}
