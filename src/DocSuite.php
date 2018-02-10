<?php

namespace Krak\Peridocs;

use Peridot\Core\Suite;

final class DocSuite
{
    public $suite;
    public $def;
    public $features;
    public $intro;
    public $outro;

    public function __construct(Suite $suite, DocDefinition $def) {
        $this->suite = $suite;
        $this->def = $def;
        $this->intro = '';
        $this->outro = '';
        $this->features = [];
    }

    public function addFeature(DocFeature $feature) {
        $this->features[] = $feature;
    }
}
