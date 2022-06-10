<?php

namespace Nilgems\PhpTextract\Extractor;

use Nilgems\PhpTextract\Concerns\AbstractExtractor;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

class XlsExtractor extends AbstractExtractor
{
    protected string $error_message = "The file content is not supported to read. Please check the file content and try again.";

    protected array $extractor_supported_extension = [
        'xls',
        'ods',
        'xlsx',
        'xlsm',
        'xltx',
        'xltm',
        'xlt',
        'ods',
        'ots',
        'csv'
        ];

    protected string $extractor_name = 'The Xls extractor';

    protected array $mime_accepts = [
        'text/csv',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
        'application/vnd.ms-excel.sheet.macroEnabled.12',
        'application/vnd.oasis.opendocument.spreadsheet',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'application/vnd.oasis.opendocument.spreadsheet-template'
    ];

    /**
     * @return bool
     * @throws Exception
     */
    protected function checkHaveProviderPackage(): bool
    {
        return IOFactory::createReaderForFile($this->file_path)->canRead($this->file_path);
    }

    protected function getTextFromFile(): string
    {
        $data_iterable = [];
        $spreadsheet = IOFactory::load($this->file_path);
        foreach ($spreadsheet->getAllSheets() as $sheet) {
            foreach ($sheet->toArray() as $item) {
                $data_iterable[] = implode(',', array_filter($item));
            }
        }
        return implode("\n", $data_iterable);
    }
}
