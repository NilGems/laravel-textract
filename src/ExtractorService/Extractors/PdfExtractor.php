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
            $file_path = $this->utilsService->getFilePath();
            $process = new Process(['pdftotext', '-layout', $file_path , '-']);
            $process->start();
            $process->wait();
            return $this->getFilteredOutput($process);
        }
        return "";
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
        throw new TextractException(trans('extractor.error_pdf_of_extension_not_installed'));
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
