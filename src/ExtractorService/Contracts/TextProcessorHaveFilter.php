<?php

namespace Nilgems\PhpTextract\ExtractorService\Contracts;

interface TextProcessorHaveFilter
{
    public function getFilteredText(string $output): string;
}