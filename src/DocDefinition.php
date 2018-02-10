<?php

namespace Krak\Peridocs;

use ReflectionFunctionAbstract;
use ReflectionFunction;

final class DocDefinition
{
    const TYPE_FN = 'fn';

    public $name;
    public $signature;
    public $type;

    public function __construct(string $name, string $signature, string $type) {
        $this->name = $name;
        $this->signature = $signature;
        $this->type = $type;
    }

    public static function createFromFunctionName(FunctionParser $parser, string $name): DocDefinition {
        return new self(
            $name,
            $parser->parseFunctionSignature($name),
            self::TYPE_FN
        );
    }
}
