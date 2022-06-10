<?php

namespace Nilgems\PhpTextract\Services;

use Illuminate\Support\Str;
use Nilgems\PhpTextract\Concerns\AbstractExtractor;
use Nilgems\PhpTextract\Concerns\TextractOutput;
use Nilgems\PhpTextract\Exceptions\TextractException;

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
     * @param array $data
     * @return TextractOutput
     * @throws TextractException
     */
    public function boot(string $file_path, string $job_id = null, array $data = []): TextractOutput
    {
        $this->file_path = $file_path;
        $this->job_id = (string) ($job_id ?? Str::uuid());
        $this->utilsService = app(UtilsService::class);
        $this->utilsService->setFilePath($this->file_path);
        $output = $this->getExtractor()->boot($this->file_path, $data);
        return new TextractOutput($output);
    }

    /**
     * Get extractor
     * @return AbstractExtractor
     * @throws TextractException
     */
    protected function getExtractor(): AbstractExtractor
    {
        if($this->utilsService->isExists()) {
            return $this->utilsService->getExtractor();
        }
        throw new TextractException('File is not available in the path:' . $this->file_path);
    }
}
