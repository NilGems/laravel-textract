<?php

namespace Nilgems\PhpTextract\Concerns;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

/**
 * @property-read string $text
 * @property-read string $word_count
 */
class TextractOutput implements Arrayable
{
    protected Collection $collection;

    /**
     * @param string $raw_output
     */
    public function __construct(string $raw_output)
    {
        $this->collection = new Collection([
            'text' => $raw_output,
            'word_count' => str_word_count($raw_output, 0)
        ]);
    }

    /**
     * To array
     * @return array
     */
    public function toArray(): array
    {
        return $this->collection->toArray();
    }

    public function __get(string $key) {
        return $this->collection->get($key);
    }

    /**
     * To string
     * @return string
     */
    public function __toString(): string
    {
        return $this->collection->get('text');
    }
}
