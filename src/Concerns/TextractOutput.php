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
            'text' => htmlspecialchars($raw_output, ENT_NOQUOTES, "UTF-8"),
            'word_count' => str_word_count(utf8_decode($raw_output), 0)
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

    public function __get(string $key)
    {
        return $this->collection->get($key);
    }

    public function __set(string $key, string $value)
    {
        $this->collection->put($key, $value);
    }

    public function __isset(string $key)
    {
        return $this->collection->has($key);
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
