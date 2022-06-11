<?php

namespace Nilgems\PhpTextract\ExtractorService\Extractors;

use Nilgems\PhpTextract\ExtractorService\ExtractorCommonProcessors\PhpWordProcessor;

class OpenOfficeDocument extends PhpWordProcessor
{
    protected string $reader_name = 'ODText';

    protected array $supported_mime_types = [
        'application/vnd.oasis.opendocument.text',
        'application/vnd.oasis.opendocument.text-template'
    ];

    public array $supported_extension = ['odt', 'ott'];
}