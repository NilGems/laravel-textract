<?php

namespace Nilgems\PhpTextract\Extractor;

use Nilgems\PhpTextract\Concerns\AbstractExtractor;
use Symfony\Component\Process\Process;

class PdfExtractor extends AbstractExtractor
{
    protected string $error_message = "'pdftotext' does not appear to be installed, so textract will be unable to extract PDFs.";

    protected string $extractor_name = 'The PDF extractor';

    protected array $extractor_supported_extension = ['pdf'];

    protected array $mime_accepts = ['application/pdf'];
    /**
     * Get the text from file
     * @return string|null
     */
    protected function getTextFromFile(): ?string
    {
        $realpath = realpath($this->file_path);
        $process = new Process(['pdftotext', '-layout', $realpath , '-']);
        $process->start();
        $process->wait();
        return $this->getFilteredOutput($process);
    }

    /**
     * Check have provider package installed in the system
     * @return bool
     */
    protected function checkHaveProviderPackage(): bool
    {
        $process = new Process(['pdftotext', '-v']);
        $process->start();
        $process->wait();
        $output = $this->getFilteredOutput($process);
        return (bool) preg_match('/pdftotext([\s]+)version/', $output);
    }

    private function getFilteredOutput(Process $process): string
    {
        $output = $process->getOutput();
        $output_error = $process->getErrorOutput();
        if(!empty($output)) {
            return $output;
        }
        return $output_error;
    }
}
