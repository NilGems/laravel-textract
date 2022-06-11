<?php

namespace Nilgems\PhpTextract\ExtractorService\Extractors;

use Nilgems\PhpTextract\ExtractorService\ExtractorCommonProcessors\TextProcessor;

class TxtExtractor extends TextProcessor
{
    protected array $supported_mime_types = [
        'text/plain'
    ];

    public array $supported_extension = ['txt'];
}