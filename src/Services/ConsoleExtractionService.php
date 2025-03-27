<?php

namespace Nilgems\PhpTextract\Services;

use Illuminate\Support\Str;
use Nilgems\PhpTextract\Concerns\TextractOutput;
use Nilgems\PhpTextract\Exceptions\TextractException;
use Nilgems\PhpTextract\ExtractorService\Options\PdfOptions;
use Nilgems\PhpTextract\ExtractorService\Options\TesseractOcrOptions;

class ConsoleExtractionService
{
    /**
     * The file path
     * @var string $file_path
     */
    protected string $file_path;
    /**
     * Job id
     * @var string $job_id
     */
    protected string $job_id;
    /**
     * Utility service
     * @var UtilsService $utilsService
     */
    protected UtilsService $utilsService;

    /**
     * Run the extractor
     * @param string $file_path
     * @param string|null $job_id
     * @param PdfOptions|null $pdfOptions
     * @param TesseractOcrOptions|null $ocrOptions
     * @return TextractOutput
     * @throws TextractException
     */
    public function boot(string $file_path, string $job_id = null, ?PdfOptions $pdfOptions = null, TesseractOcrOptions $ocrOptions = null): TextractOutput
    {
        $this->file_path = $file_path;
        $this->job_id = (string) ($job_id ?? Str::uuid());
        $this->utilsService = app(UtilsService::class);
        $this->utilsService->setFilePath($this->file_path);
        $this->utilsService->setPdfOptions($pdfOptions);
        $output = $this->utilsService->getExtractor()->boot($this->utilsService);
        return new TextractOutput($output);
    }
}
