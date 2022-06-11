<?php

namespace Nilgems\PhpTextract\ExtractorService\Extractors;

use Nilgems\PhpTextract\ExtractorService\ExtractorCommonProcessors\PhpSheetProcessor;

class MsOfficeExcelExtractor extends PhpSheetProcessor
{
    protected array $supported_mime_types = [
        'application/vnd.ms-excel',
        'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
        'application/vnd.ms-excel.sheet.macroEnabled.12',
        'application/vnd.ms-excel.template.macroenabled.12',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.template'
    ];

    public array $supported_extension = [
        'xls',
        'xlsb',
        'xlsm',
        'xltm',
        'xlsx',
        'xltx'
    ];
}
