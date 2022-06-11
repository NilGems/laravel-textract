<?php

namespace Nilgems\PhpTextract\ExtractorService\ExtractorCommonProcessors;

use Nilgems\PhpTextract\Exceptions\TextractException;
use Nilgems\PhpTextract\ExtractorService\Contracts\AbstractTextExtractor;
use PhpOffice\PhpWord\Element\Text as PhpWordElementText;
use PhpOffice\PhpWord\Element\TextRun as PhpWordElementTextRun;
use PhpOffice\PhpWord\Exception\Exception as PhpWordException;
use PhpOffice\PhpWord\IOFactory;

class PhpWordProcessor extends AbstractTextExtractor
{
    protected string $reader_name = 'Word2007';

    /**
     * @throws TextractException
     * @throws PhpWordException|TextractException
     */
    protected function getExtractedText(): string
    {
        if ($this->hasReadable()) {
            return $this->getSectionsText();
        }
        return "";
    }

    /**
     * Has the file is readable
     * @return bool
     * @throws TextractException
     * @throws PhpWordException|TextractException
     */
    private function hasReadable(): bool
    {
        $has_read_permission = IOFactory::createReader($this->reader_name)
            ->canRead($this->utilsService->getFilePath());
        if ($has_read_permission) {
            return true;
        }
        throw new TextractException(trans('textract::processor.error_unable_to_read', [
            'path' => $this->utilsService->getFilePath()
        ]));
    }

    /**
     * Collect section wise text from the Word file
     * @return string
     * @throws TextractException
     */
    protected function getSectionsText(): string
    {
        $output = [];
        $phpWord = IOFactory::load($this->utilsService->getFilePath(), $this->reader_name);
        foreach ($phpWord->getSections() as $section) {
            $elements = $section->getElements();
            $output[] = $this->getElementText($elements);
        }
        return implode(" ", array_filter($output));
    }

    /**
     * @param array $elements
     * @return string
     */
    protected function getElementText(array $elements): string
    {
        $output = [];
        foreach ($elements as $element) {
            if ($element instanceof PhpWordElementText) {
                $output[] = trim($element->getText());
            }
            if ($element instanceof PhpWordElementTextRun) {
                $output[] = $this->getElementText($element->getElements());
            }
        }
        return implode(" ", $output);
    }
}
