<?php

namespace Nilgems\PhpTextract\ExtractorService\Extractors;

use Nilgems\PhpTextract\ExtractorService\ExtractorCommonProcessors\PhpWordProcessor;

class MsOfficeDocxExtractor extends PhpWordProcessor
{
    protected array $supported_mime_types = [
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];

    public array $supported_extension = ['docx'];
}