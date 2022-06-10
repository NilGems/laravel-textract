<?php

namespace Nilgems\PhpTextract\Extractor;

use Nilgems\PhpTextract\Concerns\AbstractExtractor;
use Nilgems\PhpTextract\Extractor\Contracts\HasPhpWord;
use PhpOffice\PhpWord\IOFactory;

class DocxExtractor extends AbstractExtractor
{
    use HasPhpWord;

    protected string $error_message = "The file content is not supported to read. Please check the file content and try again.";

    protected string $extractor_name = 'The Docx extractor';

    protected array $extractor_supported_extension = ['docx'];

    protected array $mime_accepts = [
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];

    /**
     * @return bool
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    protected function checkHaveProviderPackage(): bool
    {
        return IOFactory::createReader('Word2007')->canRead($this->file_path);
    }

    /**
     * @return string
     */
    protected function getTextFromFile(): string
    {
        return $this->getSectionsText($this->file_path);
    }

}
