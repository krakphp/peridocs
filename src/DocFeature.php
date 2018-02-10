<?php

namespace Krak\Peridocs;

final class DocFeature
{
    public $description; /** test description */
    public $code; /** formatted php code as a string */

    public function __construct(string $description, string $code) {
        $this->description = $description;
        $this->code = $code;
    }
}
