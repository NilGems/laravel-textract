<?php

namespace Nilgems\PhpTextract\ExtractorService\Extractors;

use Nilgems\PhpTextract\ExtractorService\ExtractorCommonProcessors\PhpWordProcessor;

class MsOfficeDocExtractor extends PhpWordProcessor
{
    protected array $supported_mime_types = [
        'application/msword'
    ];

    public array $supported_extension = ['doc'];

    protected string $reader_name = 'MsDoc';
}