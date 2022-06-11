<?php

namespace Nilgems\PhpTextract\ExtractorService\Extractors;

use Nilgems\PhpTextract\ExtractorService\Contracts\TextProcessorHaveFilter;
use Nilgems\PhpTextract\ExtractorService\ExtractorCommonProcessors\TextProcessor;

class HtmlExtractor extends TextProcessor implements TextProcessorHaveFilter
{
    protected array $supported_mime_types = [
        'text/html'
    ];

    public array $supported_extension = ['html', 'htm'];

    /**
     * Remove the tags from the output text
     * @param string $output
     * @return string
     */
    public function getFilteredText(string $output): string
    {
        if (!empty($output)) {
            return strip_tags($output);
        }
        return "";
    }
}
