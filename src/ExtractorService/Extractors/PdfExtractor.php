<?php

namespace Nilgems\PhpTextract\ExtractorService\Extractors;

use Nilgems\PhpTextract\Exceptions\TextractException;
use Nilgems\PhpTextract\ExtractorService\Contracts\AbstractTextExtractor;
use Symfony\Component\Process\Process;

class PdfExtractor extends AbstractTextExtractor
{
    protected array $supported_mime_types = [
        'application/pdf'
    ];

    public array $supported_extension = ['pdf'];

    /**
     * @return string
     * @throws TextractException
     */
    protected function getExtractedText(): string
    {
        if ($this->hasOsExtensionInstalled()) {
            $params = $this->getExtractionCommandParams();
            $process = new Process($params);
            $process->start();
            $process->wait();
            return $this->getFilteredOutput($process);
        }
        return "";
    }

    protected function getExtractionCommandParams(): array
    {
        $params = ['pdftotext'];
        $file_path = $this->utilsService->getFilePath();
        $options = $this->utilsService->getPdfOptions();
        if (!empty($options)) {
            if (!is_null($options?->firstPage)) {
                $params[] = '-f';
                $params[] = $options?->firstPage;
            }
            if (!is_null($options?->lastPage)) {
                $params[] = '-l';
                $params[] = $options?->lastPage;
            }
            if (!is_null($options?->resolution)) {
                $params[] = '-r';
                $params[] = $options->resolution;
            }
            if (!is_null($options?->xCoordinate)) {
                $params[] = '-x';
                $params[] = $options->xCoordinate;
            }
            if (!is_null($options?->yCoordinate)) {
                $params[] = '-y';
                $params[] = $options->yCoordinate;
            }
            if (!is_null($options?->widthOfCorpArea)) {
                $params[] = '-W';
                $params[] = $options->widthOfCorpArea;
            }
            if (!is_null($options?->heightOfCorpArea)) {
                $params[] = '-H';
                $params[] = $options->heightOfCorpArea;
            }
            if ($options?->layoutModeEnabled) {
                $params[] = '-layout';
            }
            if (!is_null($options?->fixedPitch)) {
                $params[] = '-fixed';
                $params[] = $options->fixedPitch;
            }
            if ($options?->rawEnabled) {
                $params[] = '-raw';
            }
            if (!is_null($options?->encodingName)) {
                $params[] = '-enc';
                $params[] = $options->encodingName;
            }
            if ($options?->noPageBreaksEnabled) {
                $params[] = '-nopgbrk';
            }
            if (!is_null($options?->ownerPassword)) {
                $params[] = '-opw';
                $params[] = $options->ownerPassword;
            }
            if (!is_null($options?->ownerPassword)) {
                $params[] = '-upw';
                $params[] = $options->userPassword;
            }
        }
        $params[] = $file_path;
        $params[] = '-';
        return $params;
    }

    /**
     * Has 'pdftotext' extension is installed or enabled in OS.
     * @return bool
     * @throws TextractException
     */
    private function hasOsExtensionInstalled(): bool
    {
        $process = new Process(['pdftotext', '-v']);
        $process->start();
        $process->wait();
        $output = $this->getFilteredOutput($process);
        $has_extension = (bool) preg_match('/pdftotext([\s]+)version/', $output);
        if ($has_extension) {
            return true;
        }
        throw new TextractException(trans('textract::extractor.error_pdf_of_extension_not_installed'));
    }

    /**
     * @param Process $process
     * @return string
     */
    private function getFilteredOutput(Process $process): string
    {
        $output = $process->getOutput();
        $output_error = $process->getErrorOutput();
        if (!empty($output)) {
            return $output;
        }
        return $output_error;
    }
}
