<?php

namespace Nilgems\PhpTextract\ExtractorService\ExtractorCommonProcessors;

use Nilgems\PhpTextract\Exceptions\TextractException;
use Nilgems\PhpTextract\ExtractorService\Contracts\AbstractTextExtractor;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PhpSheetProcessor extends AbstractTextExtractor
{
    /**
     * @return bool
     * @throws TextractException
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    private function hasReadable(): bool
    {
        $file_path = $this->utilsService->getFilePath();
        $has_readable = IOFactory::createReaderForFile($file_path)->canRead($file_path);
        if ($has_readable) {
            return true;
        }
        throw new TextractException(trans('textract::processor.error_unable_to_read', [
            'path' => $this->utilsService->getFilePath()
        ]));
    }

    /**
     * @throws TextractException
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    protected function getExtractedText(): string
    {
        if ($this->hasReadable()) {
            $data_iterable = [];
            $spreadsheet = IOFactory::load($this->utilsService->getFilePath());
            foreach ($spreadsheet->getAllSheets() as $sheet) {
                foreach ($sheet->toArray() as $item) {
                    $data_iterable[] = implode(',', array_filter($item));
                }
            }
            return implode("\n", $data_iterable);
        }
        return "";
    }
}
