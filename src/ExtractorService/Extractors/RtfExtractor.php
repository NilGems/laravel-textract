<?php

namespace Nilgems\PhpTextract\ExtractorService\Extractors;

use Nilgems\PhpTextract\ExtractorService\ExtractorCommonProcessors\PhpWordProcessor;

class RtfExtractor extends PhpWordProcessor
{
    protected string $reader_name = 'RTF';

    protected array $supported_mime_types = [
        'application/rtf',
        'text/rtf'
    ];

    public array $supported_extension = ['rtf'];
}