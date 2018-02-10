<?php

namespace Krak\Peridocs;

interface FormatDocs
{
    public function formatDocs(FormatDocsArgs $args): string;
}
