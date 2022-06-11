<?php

namespace Nilgems\PhpTextract\ExtractorService\Contracts;

use Illuminate\Support\Str;
use Nilgems\PhpTextract\Exceptions\TextractException;
use Nilgems\PhpTextract\Services\UtilsService;

abstract class AbstractTextExtractor
{
    /**
     * Extractor utils service
     * @var UtilsService $utilsService
     */
    protected UtilsService $utilsService;
    /**
     * Extractor supported extension
     * @var array $supported_extension
     */
    public array $supported_extension = [];
    /**
     * Extractor supported mime types
     * @var array $supported_mime_types
     */
    protected array $supported_mime_types = [];

    /**
     * Run the extractor and get the output
     * @param UtilsService $utilsService
     * @return string
     * @throws TextractException
     */
    public function boot(UtilsService $utilsService): string
    {
        $this->utilsService = $utilsService;
        if ($this->hasSupportedExtensionDefined() && $this->utilsService->getFilePath() && $this->hasMatchMimeType()) {
            return $this->getExtractedText();
        }
        return "";
    }

    /**
     * Check the supported file format is defined or not.
     * @return bool
     * @throws TextractException
     */
    private function hasSupportedExtensionDefined(): bool
    {
        if (!empty($this->supported_extension)) {
            return true;
        }
        throw new TextractException(trans('textract::extractor.error_supported_extension_not_defined'));
    }

    /**
     * Check the mime type of file provided via path is match or not
     * @return bool
     * @throws TextractException
     */
    private function hasMatchMimeType(): bool
    {
        $current_file_mime_type = strtolower($this->utilsService->getFileMimeType());
        $is_match_mime_type = collect($this->supported_mime_types)
            ->transform(function ($mime_type) {
                return strtolower($mime_type);
            })
            ->filter(function ($mime_type) use ($current_file_mime_type) {
                return Str::of($mime_type)->exactly($current_file_mime_type);
            })
            ->count() > 0;
        if (!$is_match_mime_type) {
            throw new TextractException(trans_choice('textract::extractor.error_mime_mismatch', count($this->supported_extension), [
                'path' => $this->utilsService->getFilePath(),
                'extension' => implode(', .', $this->supported_extension),
                'mime_types' => implode(', ', $this->supported_mime_types)
            ]));
        }
        return true;
    }

    abstract protected function getExtractedText(): string;
}
