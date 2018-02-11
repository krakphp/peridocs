<?php

namespace Krak\Peridocs\FormatDocs;

use Krak\Peridocs\{FormatDocs, FormatDocsArgs};

final class MarkdownFormatDocs implements FormatDocs
{
    public function formatDocs(FormatDocsArgs $args): string {
        $headerFmt = $args->config['headerFmt'] ?? '<h3 id="{id}">{signature}</h3>';
        $showLinks = $args->config['showLinks'] ?? false;
        $nsPrefix = $args->config['nsPrefix'] ?? '';
        $docSuites = $args->docSuites;

        return ($showLinks ? $this->generateTableLinks($docSuites, $nsPrefix) . "\n\n" : '')
            . $this->generateApiContent($docSuites, $headerFmt);
    }

    private function slugDocSuiteName($docSuite) {
        return strtolower(str_replace('\\', '-', $docSuite->def->name));
    }

    private function generateTableLinks($docSuites, string $nsPrefix) {
        $chunks = array_chunk($docSuites, 4);

        return '<table>' . array_reduce($chunks, function($acc, $chunk) use ($nsPrefix) {
            return $acc . '<tr>' . array_reduce($chunk, function($acc, $docSuite) use ($nsPrefix) {
                return $acc
                    . '<td><a href="#api-' . $this->slugDocSuiteName($docSuite) . '">'
                        . str_replace($nsPrefix, '', $docSuite->def->name)
                    . '</a></td>';
            }, '') . '</tr>';
        }, '') . '</table>';
    }

    private function generateApiContent($docSuites, $headerFmt) {
        return array_reduce($docSuites, function($acc, $docSuite) use ($headerFmt) {
            $featureDocs = array_reduce($docSuite->features, function($acc, $feature) {
                return $acc . sprintf("%s:\n\n```php\n%s\n```\n\n", $feature->description, $feature->code);
            }, '');

            $formattedDoc = strtr($headerFmt, [
                    '{id}' => 'api-' . $this->slugDocSuiteName($docSuite),
                    '{signature}' => $docSuite->def->signature,
                ])
                . "\n\n**Name:** `{$docSuite->def->name}`\n\n"
                . ($docSuite->intro ? $docSuite->intro . "\n\n" : '')
                . $featureDocs
                . $docSuite->outro;
            return $acc ? $acc . "\n\n" . $formattedDoc : $formattedDoc;
        }, '');
    }
}
