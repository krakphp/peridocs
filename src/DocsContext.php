<?php

namespace Krak\Peridocs;

use Peridot\Core\{Suite, TestInterface};

final class DocsContext
{
    private static $instance;

    private $suitesMap;
    private $functionParser;
    private $formatDocs;
    private $config;

    public function __construct(FormatDocs $formatDocs = null, array $config = []) {
        $this->suitesMap = new \SplObjectStorage();
        $this->functionParser = FunctionParser::create();
        $this->formatDocs = $formatDocs ?: new FormatDocs\MarkdownFormatDocs();
        $this->config = $config;
    }

    public static function setInstance(DocsContext $ctx) {
        self::$instance = $ctx;
    }
    public static function getInstance() {
        self::$instance = self::$instance ?: new self();
        return self::$instance;
    }

    public function addDocFn(Suite $suite, $name) {
        $ds = new DocSuite($suite, DocDefinition::createFromFunctionName($this->functionParser, $name));
        $this->suitesMap->attach($ds->suite, $ds);
    }

    public function addDocFeature(TestInterface $test) {
        if (!isset($this->suitesMap[$test->getParent()])) {
            return;
        }
        if (!$test->getDefinition() instanceof \Closure) {
            throw new \LogicException("Test definition for doc suite must be defined as a Closure.");
        }

        $docSuite = $this->suitesMap[$test->getParent()];
        $docSuite->addFeature(new DocFeature(
            $test->getDescription(),
            $this->functionParser->parseClosureStatements($test->getDefinition())
        ));
    }

    public function setDocIntro(Suite $suite, string $intro) {
        $docSuite = $this->suitesMap[$suite];
        $docSuite->intro = $intro;
    }
    public function setDocOutro(Suite $suite, string $outro) {
        $docSuite = $this->suitesMap[$suite];
        $docSuite->outro = $outro;
    }

    public function formatDocs() {
        $docSuites = [];
        foreach ($this->suitesMap as $suite) {
            $docSuites[] = $this->suitesMap[$suite];
        }

        return $this->formatDocs->formatDocs(new FormatDocsArgs($docSuites, $this->config));
    }
}

