<?php

namespace Nilgems\PhpTextract\ExtractorService\Extractors;

use Html2Text\Html2Text;
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
            return (new Html2Text($output))->getText();
        }
        return "";
    }
}
