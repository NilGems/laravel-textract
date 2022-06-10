<?php

namespace Nilgems\PhpTextract\Extractor\Contracts;

use PhpOffice\PhpWord\Element\Cell;
use PhpOffice\PhpWord\Element\Text as PhpWordElementText;
use PhpOffice\PhpWord\Element\TextRun as PhpWordElementTextRun;
use PhpOffice\PhpWord\IOFactory;

trait HasPhpWord
{
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

    protected function getElementText(array $elements): array {
        $docs = [];
        foreach ($elements as $element) {
            if($element instanceof PhpWordElementText) {
                $docs[] = trim($element->getText());
            }
            if($element instanceof PhpWordElementTextRun) {
                $nested_data = $this->getElementText($element->getElements());
                $docs = [...$docs, ...$nested_data];
            }
//            if($element instanceof PhpWordElementTable) {
//                $nested_data = $this->getTableRowText($element->getRows());
//                $docs = [...$docs, ...$nested_data];
//            }
        }
        return $docs;
    }

    protected function getTableRowText(array $rows): array
    {
        $data = [];
        foreach ($rows as $row) {
            foreach ($row->getCells() as $cell) {
                if($cell instanceof Cell) {
                    $data[] = $this->getElementText($cell->getElements());
                }
            }
        }
        return $data;
    }
}
