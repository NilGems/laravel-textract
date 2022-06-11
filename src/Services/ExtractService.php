<?php

namespace Nilgems\PhpTextract\Services;

use Illuminate\Support\Str;
use Nilgems\PhpTextract\Concerns\TextractOutput;
use Nilgems\PhpTextract\Exceptions\TextractException;

class ExtractService
{
    protected string $file_path;
    protected string $job_id;

    /**
     * @throws TextractException
     */
    public function run(string $file_path, string $job_id = null): TextractOutput
    {
        $this->file_path = $file_path;
        $this->job_id = (string) ($job_id ?? Str::uuid());
        return app(ConsoleExtractionService::class)
            ->boot($this->file_path, $this->job_id);
    }

    /**
     * Get file path
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->file_path;
    }

    /**
     * Get job id
     * @return string
     */
    public function getJobId(): string
    {
        return $this->job_id;
    }
}
