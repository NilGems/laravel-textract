<?php

namespace Nilgems\PhpTextract\Extractor;

use Nilgems\PhpTextract\Concerns\AbstractExtractor;
use Nilgems\PhpTextract\Extractor\Contracts\HasPhpWord;
use PhpOffice\PhpWord\IOFactory;

class OdtExtractor extends AbstractExtractor
{
    use HasPhpWord;

    protected string $error_message = "The file content is not supported to read. Please check the file content and try again.";

    protected array $mime_accepts = [
        'application/vnd.oasis.opendocument.text'
    ];

    protected array $extractor_supported_extension = ['odt'];

    protected string $extractor_name = 'The Odt extractor';

    /**
     * @return bool
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    protected function checkHaveProviderPackage(): bool
    {
        return IOFactory::createReader('ODText')->canRead($this->file_path);
    }

    /**
     * Get the text content
     * @return string
     */
    protected function getTextFromFile(): string
    {
        return $this->getSectionsText($this->file_path, 'ODText');
    }
}
