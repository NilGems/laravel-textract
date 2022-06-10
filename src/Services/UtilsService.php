<?php

namespace Nilgems\PhpTextract\Services;

use Illuminate\Support\Collection;
use Nilgems\PhpTextract\Concerns\AbstractExtractor;
use Nilgems\PhpTextract\Exceptions\TextractException;
use Nilgems\PhpTextract\Providers\ServiceProvider;

class UtilsService
{
    protected string $file_path;
    protected string $file_name;
    protected string $file_extension;
    protected string $file_mime_type;
    protected Collection $extractor_collection;
    protected array $supported_file_extensions;

    public function setFilePath(string $file_path): self {
        $this->file_path = $file_path;
        $this->file_name = $this->getFileName();
        $this->file_extension = $this->getFileExtension();
        $this->file_mime_type = $this->getFileMimeType();
        $this->extractor_collection = collect(array_keys(ServiceProvider::EXTRACTORS))->transform(fn($extractor) => app()->get('extractor-' . $extractor));
        $this->supported_file_extensions = (clone $this->extractor_collection)->transform(fn(AbstractExtractor $extractor) => $extractor->getAcceptExtensions())->flatten()->toArray();
        return $this;
    }

    public function isExists(): bool
    {
        if(isset($this->file_path)) {
            return file_exists($this->file_path);
        }
        return false;
    }

    /**
     * Get the extractor
     * @return AbstractExtractor
     * @throws TextractException
     */
    public function getExtractor(): AbstractExtractor {
        if(isset($this->file_mime_type)) {
            $selected_extractor =  (clone $this->extractor_collection)->filter(fn(AbstractExtractor $extractor) => $extractor->hasMatchMimeType($this->file_mime_type));
            if($selected_extractor->count() > 0) {
                return $selected_extractor->first();
            }
            throw new TextractException("Invalid file format. Only support ".implode('/', $this->supported_file_extensions)." files");
        }
        throw new TextractException("Please provide a file to extract text from that.");
    }

    /**
     * Get the file name from the file path
     * @return string|null
     */
    public function getFileName(): ?string
    {
        if(isset($this->file_path)) {
            return basename($this->file_path);
        }
        return null;
    }

    /**
     * Get file extension from the file path
     * @return string|null
     */
    public function getFileExtension(): ?string
    {
        if(isset($this->file_path)) {
            return pathinfo($this->file_path, PATHINFO_EXTENSION);
        }
        return null;
    }

    /**
     * Get file mime type from the file
     * @return string|null
     */
    public function getFileMimeType(): ?string
    {
        if(isset($this->file_path)) {
            return mime_content_type($this->file_path);
        }
        return null;
    }
}
