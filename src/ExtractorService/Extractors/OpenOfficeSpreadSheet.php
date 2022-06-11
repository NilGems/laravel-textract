<?php

namespace Nilgems\PhpTextract\ExtractorService\Extractors;

use Nilgems\PhpTextract\ExtractorService\ExtractorCommonProcessors\PhpSheetProcessor;

class OpenOfficeSpreadSheet extends PhpSheetProcessor
{
    protected array $supported_mime_types = [
        'application/vnd.oasis.opendocument.spreadsheet',
        'application/vnd.oasis.opendocument.spreadsheet-template'
    ];

    public array $supported_extension = ['ods', 'ots'];
}