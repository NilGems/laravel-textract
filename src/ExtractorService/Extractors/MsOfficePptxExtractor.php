<?php

namespace Nilgems\PhpTextract\ExtractorService\Extractors;

use Nilgems\PhpTextract\ExtractorService\ExtractorCommonProcessors\PhpPowerPointProcessor;

class MsOfficePptxExtractor extends PhpPowerPointProcessor
{
    protected string $readerType = "PowerPoint2007";

    protected array $supported_mime_types = [
        'application/vnd.openxmlformats-officedocument.presentationml.presentation'
    ];

    public array $supported_extension = ['pptx'];

    protected string $reader_name = 'MsPresentation';
}
