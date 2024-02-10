<?php

namespace Nilgems\PhpTextract\ExtractorService\Extractors;

use Nilgems\PhpTextract\ExtractorService\ExtractorCommonProcessors\PhpPowerPointProcessor;

class MsOfficePptExtractor extends PhpPowerPointProcessor
{
    protected string $readerType = "PowerPoint97";

    protected array $supported_mime_types = [
        'application/vnd.ms-powerpoint'
    ];

    public array $supported_extension = ['ppt'];

    protected string $reader_name = 'MsPresentation';
}
