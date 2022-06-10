<?php

namespace Nilgems\PhpTextract\Console;

use Illuminate\Console\Command;
use Nilgems\PhpTextract\Console\Contracts\MustHaveExtractCommand;
use Nilgems\PhpTextract\Services\ConsoleExtractionService;

class TextractCommand extends Command implements MustHaveExtractCommand
{
    protected $name = "Textract command";

    protected $signature = 'textract:run {file_path} {job_id}';

    protected $description = 'Extract text from the supported file';

    public function handle(): int {
        $file_path = $this->argument('file_path');
        $job_id = $this->argument('job_id');
        $output = app()->get('textract')->run($file_path, $job_id);
        info($output);
        return 1;
    }
}
