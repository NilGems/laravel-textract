<?php

namespace Nilgems\PhpTextract\Concerns;

interface MustHaveResponse
{
    public function __construct(string $job_id, string $file_path, string $output = null, string $error = null);
}
