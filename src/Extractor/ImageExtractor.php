<?php

namespace Nilgems\PhpTextract\Extractor;

use Nilgems\PhpTextract\Concerns\AbstractExtractor;
use thiagoalessio\TesseractOCR\TesseractOCR;

class ImageExtractor extends AbstractExtractor
{
    protected string $error_message = "The file content is not supported to read. Please check the file content and try again.";

    protected array $mime_accepts = [
        'image/png',
        'image/jpeg',
        'image/gif'
    ];

    protected array $extractor_supported_extension = [
        'jpg',
        'gif',
        'png'
    ];

    protected string $extractor_name = 'The Image extractor';

    /**
     * @return bool
     */
    protected function checkHaveProviderPackage(): bool
    {
        return !empty((new TesseractOCR($this->file_path))->version());
    }

    /**
     * @return string
     * @throws \thiagoalessio\TesseractOCR\TesseractOcrException
     */
    protected function getTextFromFile(): string
    {
        $languages = $this->data->get('lang', []);
        $ocr = (new TesseractOCR($this->file_path));
        if(!empty($languages)) {
            $ocr->lang(...$languages);
        }
        return $ocr->run();
    }
}
