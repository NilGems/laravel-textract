<?php

namespace Nilgems\PhpTextract;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Nilgems\PhpTextract\Concerns\TextractOutput run(string $file_path, string $job_id=null, array $data = [])
 */
class Textract extends Facade
{
    protected static function getFacadeAccessor() {
        return 'textract';
    }
}
