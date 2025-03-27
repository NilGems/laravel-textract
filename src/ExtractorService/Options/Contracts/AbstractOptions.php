<?php

namespace Nilgems\PhpTextract\ExtractorService\Options\Contracts;

abstract class AbstractOptions
{
    /**
     * Get the new option instance.
     * @return static
     */
    public static function create(): static
    {
        return new static();
    }
}