<?php

namespace Nilgems\PhpTextract\Extractor;

use Nilgems\PhpTextract\Concerns\AbstractExtractor;
use Nilgems\PhpTextract\Exceptions\TextractException;
use Nilgems\PhpTextract\Extractor\Contracts\HasPhpWord;
use PhpOffice\PhpWord\IOFactory;

class DocExtractor extends AbstractExtractor
{
    use HasPhpWord;

    protected string $file_path;

    protected string $error_message = "The file content is not supported to read. Please check the file content and try again.";

    protected string $extractor_name = 'The DOC extractor.';

    protected array $extractor_supported_extension = ['doc'];

    protected array $mime_accepts = [
        'application/msword'
    ];

    /**
     * Check have provider package installed in the system
     * @return bool
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    protected function checkHaveProviderPackage(): bool
    {
        return IOFactory::createReader('MsDoc')->canRead($this->file_path);
    }

    /**
     * @return null
     * @throws TextractException
     */
    protected function getTextFromFile()
    {
        return $this->getSectionsText($this->file_path, 'MsDoc');
    }
}
