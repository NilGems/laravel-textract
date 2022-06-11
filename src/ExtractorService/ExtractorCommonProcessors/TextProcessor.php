<?php

namespace Nilgems\PhpTextract\ExtractorService\ExtractorCommonProcessors;

use Nilgems\PhpTextract\Exceptions\TextractException;
use Nilgems\PhpTextract\ExtractorService\Contracts\AbstractTextExtractor;
use Nilgems\PhpTextract\ExtractorService\Contracts\TextProcessorHaveFilter;

class TextProcessor extends AbstractTextExtractor
{
    /**
     * @return string
     * @throws TextractException
     */
    protected function getExtractedText(): string
    {
        if ($file_resource = $this->hasReadable()) {
            $file_size = filesize($this->utilsService->getFilePath());
            $read_data = fread($file_resource, $file_size);
            fclose($file_resource);
            if ($this instanceof TextProcessorHaveFilter) {
                return $this->getExtractedText($read_data);
            }
            return $read_data;
        }
        return "";
    }

    /**
     * @return resource
     * @throws TextractException
     */
    private function hasReadable()
    {
        if ($file_resource = fopen($this->utilsService->getFilePath(), 'rb')) {
            return $file_resource;
        }
        throw new TextractException(trans('textract::processor.error_unable_to_read', [
            'path' => $this->utilsService->getFilePath()
        ]));
    }
}
