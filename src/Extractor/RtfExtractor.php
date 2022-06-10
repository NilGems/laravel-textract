<?php

namespace Nilgems\PhpTextract\Extractor;

use Nilgems\PhpTextract\Concerns\AbstractExtractor;
use Nilgems\PhpTextract\Extractor\Contracts\HasPhpWord;
use PhpOffice\PhpWord\IOFactory;

class RtfExtractor extends AbstractExtractor
{
    use HasPhpWord;

    protected string $extractor_name = 'The rtf extractor';

    protected array $extractor_supported_extension = ['rtf'];

    protected array $mime_accepts = [
        'application/rtf',
        'text/rtf'
    ];

    protected string $error_message = "The file content is not supported to read. Please check the file content and try again.";

    /**
     * @return bool
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    protected function checkHaveProviderPackage(): bool
    {
        return IOFactory::createReader('RTF')->canRead($this->file_path);
    }

    /**
     * @return string
     */
    protected function getTextFromFile(): string
    {
        return $this->getSectionsText($this->file_path, 'RTF');
    }
}
