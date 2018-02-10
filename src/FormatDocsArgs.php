<?php

namespace Krak\Peridocs;

final class FormatDocsArgs
{
    public $docSuites;
    public $config;

    public function __construct(array $docSuites, array $config = []) {
        $this->docSuites = $docSuites;
        $this->config = $config;
    }
}

