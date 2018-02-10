<?php

namespace Krak\Peridocs\FormatDocs;

use Krak\Peridocs\{FormatDocs, FormatDocsArgs};

final class MarkdownFormatDocs implements FormatDocs
{
    public function formatDocs(FormatDocsArgs $args): string {
        $headerFmt = $args->config['headerFmt'] ?? '### %s';

        return array_reduce($args->docSuites, function($acc, $docSuite) use ($headerFmt) {
            $featureDocs = array_reduce($docSuite->features, function($acc, $feature) {
                return $acc . sprintf("%s:\n\n```php\n%s\n```\n\n", $feature->description, $feature->code);
            }, '');

            $formattedDoc = sprintf($headerFmt, $docSuite->def->signature)
                          . "\n\n**Name:** {$docSuite->def->name}\n\n"
                          . ($docSuite->intro ? $docSuite->intro . "\n\n" : '')
                          . $featureDocs
                          . $docSuite->outro;
            return $acc ? $acc . "\n\n" . $formattedDoc : $formattedDoc;
        }, '');
    }
}
