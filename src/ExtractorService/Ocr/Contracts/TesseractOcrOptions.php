<?php

namespace Nilgems\PhpTextract\ExtractorService\Ocr\Contracts;

use Illuminate\Contracts\Support\Arrayable;

class TesseractOcrOptions implements Arrayable
{
    protected array $options;



    public function __construct()
    {
        $this->options = [
            'executable' => config('textract.ocr.executable_path', null),
            'tempDir' => config('textract.ocr.temp_dir', null),
            'userWords' => config('textract.ocr.text_dictionary_path'),
            'userPatterns' => config('textract.ocr.text_patterns_path'),
            'lang' => [],
            'allowlist' => [],
            'configVar' => config('textract.ocr.config'),
            'psm' => null,
            'dpi' => null,
            'threadLimit' => config('textract.ocr.thread_limit'),

        ];
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setTempDir(string $path): self
    {
        $this->options['tempDir'] = $path;
        return $this;
    }

    /**
     * Add languages
     * @param array $language
     * @return $this
     */
    public function setLanguage(array $language): self
    {
        $this->options['lang'] = $language;
        return $this;
    }

    /**
     * @param int $psm
     * @return $this
     */
    public function setPsm(int $psm): self
    {
        $this->options['psm'] = $psm;
        return $this;
    }

    /**
     * @param array $list
     * @return $this
     */
    public function setAllowList(array $list): self
    {
        $this->options['allowlist'] = $list;
        return $this;
    }

    public function toArray(): array
    {
        return array_filter($this->options, static function ($option_value) {
            return !empty($option_value);
        });
    }
}
