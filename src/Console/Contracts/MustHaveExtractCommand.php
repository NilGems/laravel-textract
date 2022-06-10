<?php

namespace Nilgems\PhpTextract\Console\Contracts;

interface MustHaveExtractCommand
{
    public function handle(): int;
}
