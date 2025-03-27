<?php

namespace Nilgems\PhpTextract\ExtractorService\ExtractorCommonProcessors;

use Nilgems\PhpTextract\Exceptions\TextractException;
use Nilgems\PhpTextract\ExtractorService\Contracts\AbstractTextExtractor;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Shape;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

/**
 * PHP PowerPointProcessor
 * Read the document: https://phpoffice.github.io/PHPPresentation/usage/readers.html
 */
class PhpPowerPointProcessor extends AbstractTextExtractor
{
    protected string $readerType = "PowerPoint2007";

    /**
     * @return bool
     * @throws TextractException
     */
    private function hasReadable(): bool
    {
        $file_path = $this->utilsService->getFilePath();
        $reader = IOFactory::createReader($this->readerType);
        try {
            $presentation = $reader->load($file_path);
            return count($presentation->getAllSlides()) > 0;
        } catch (\Exception $exception) {
            report($exception);
            throw new TextractException(trans('textract::processor.error_unable_to_read', [
                'path' => $this->utilsService->getFilePath()
            ]));
        }

    }

    /**
     * @throws TextractException
     * @throws Exception
     */
    protected function getExtractedText(): string
    {
        if ($this->hasReadable()) {
            $data_iterable = [];
            $reader = IOFactory::createReader($this->readerType);
            $presentation = $reader->load($this->utilsService->getFilePath());
            foreach ($presentation->getAllSlides() as $slide) {
                $shapes = $slide->getShapeCollection();
                foreach ($shapes as $shape_k => $shape_v) {
                    $shape = $shapes[$shape_k];
                    if($shape instanceof Shape\RichText){
                        $paragraphs = $shapes[$shape_k]->getParagraphs();
                        foreach ($paragraphs as $paragraph_k => $paragraph_v) {
                            $text_elements = $paragraph_v->getRichTextElements();
                            foreach ($text_elements as $text_element_k => $text_element_v) {
                                $data_iterable[] = $text_element_v->getText();
                            }
                        }
                    }
                }
            }
            return implode("\n", $data_iterable);
        }
        return "";
    }
}
