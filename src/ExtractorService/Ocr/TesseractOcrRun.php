<?php

namespace Nilgems\PhpTextract\ExtractorService\Ocr;

use Nilgems\PhpTextract\Exceptions\TextractException;
use Nilgems\PhpTextract\ExtractorService\Ocr\Contracts\TesseractOcrOptions;
use Nilgems\PhpTextract\Services\UtilsService;
use Symfony\Component\Process\Process;
use thiagoalessio\TesseractOCR\TesseractOCR;

class TesseractOcrRun
{
    protected UtilsService $utilsService;

    /**
     * @param UtilsService $utilsService
     * @param TesseractOcrOptions|null $ocrOptions
     * @return string
     * @throws TextractException
     * @throws \thiagoalessio\TesseractOCR\TesseractOcrException
     */
    public function boot(UtilsService $utilsService, TesseractOcrOptions $ocrOptions = null): string
    {
        $this->utilsService = $utilsService;
        $is_enabled = config('textract.ocr.enabled', false);
        if ($is_enabled && $this->hasOsExtension() && $this->utilsService->getFilePath()) {
            return $this->getOcr($ocrOptions)->run();
        }
        return "";
    }

    protected function getOcr(TesseractOcrOptions $ocrOptions = null): TesseractOCR
    {
        if ($ocrOptions === null) {
            $ocrOptions = new TesseractOcrOptions();
        }
        $ocr = new TesseractOCR($this->utilsService->getFilePath());
        $ocr->withoutTempFiles();
        if ($ocrOptions) {
            foreach ($ocrOptions->toArray() as $option_key => $option_value) {
                $ocr->{$option_key}(...$option_value);
            }
        }
        return $ocr;
    }

    /**
     * @return bool
     * @throws TextractException
     */
    protected function hasOsExtension(): bool
    {
        $process = new Process(['tesseract', '-v']);
        $process->start();
        $process->wait();
        $output = $this->getConsoleOutput($process);
        $has_installed = (bool) preg_match('/tesseract([\s]+)([0-9.]+)/', $output);
        if ($has_installed) {
            return true;
        }
        throw new TextractException(trans('textract::tesseract.error_not_installed'));
    }

    /**
     * @param Process $process
     * @return string
     */
    protected function getConsoleOutput(Process $process): string
    {
        if ($output = $process->getOutput()) {
            return $output;
        }
        return $process->getErrorOutput();
    }
}
