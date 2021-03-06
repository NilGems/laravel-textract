<?php

namespace Nilgems\PhpTextract\ExtractorService\Contracts;

use PhpOffice\PhpWord\Element\Text as PhpWordElementText;
use PhpOffice\PhpWord\Element\TextRun as PhpWordElementTextRun;
use PhpOffice\PhpWord\IOFactory;

trait HasPhpWord
{
    /**
     * @param string $file_path
     * @param string $readerName
     * @return string
     */
    protected function getSectionsText(string $file_path, string $readerName = 'Word2007'): string
    {
        $data = [];
        $phpWord = IOFactory::load($file_path, $readerName);
        foreach ($phpWord->getSections() as $section) {
            $elements = $section->getElements();
            $data  = [...$data, ...$this->getElementText($elements)];
        }
        return implode(" ", array_filter($data));
    }

    /**
     * @param array $elements
     * @return array
     */
    protected function getElementText(array $elements): array
    {
        $docs = [];
        foreach ($elements as $element) {
            if ($element instanceof PhpWordElementText) {
                $docs[] = trim($element->getText());
            }
            if ($element instanceof PhpWordElementTextRun) {
                $nested_data = $this->getElementText($element->getElements());
                $docs = [...$docs, ...$nested_data];
            }
        }
        return $docs;
    }

}
