<?php

namespace Nilgems\PhpTextract\Services;

use Illuminate\Support\Collection;
use Nilgems\PhpTextract\Exceptions\TextractException;
use Nilgems\PhpTextract\ExtractorService\Contracts\AbstractTextExtractor;
use Nilgems\PhpTextract\ExtractorService\Options\PdfOptions;

class UtilsService
{
    /**
     * Extractable file path
     * @var string $file_path
     */
    protected string $file_path;
    /**
     * Extractable file name
     * @var string $file_name
     */
    protected string $file_name;
    /**
     * Extractable file extension
     * @var string $file_extension
     */
    protected string $file_extension;
    /**
     * Extractable file mime type
     * @var string $file_mime_type
     */
    protected string $file_mime_type;
    /**
     * ExtractorService collection
     * @var Collection $extractor_collection
     */
    protected Collection $extractor_collection;
    /**
     * Extraction supported file extension
     * @var array $supported_file_extensions
     */
    protected array $supported_file_extensions = [];

    protected ?PdfOptions $pdf_options = null;
    /**
     * Set file path
     * @param string $file_path
     * @return $this
     */
    public function setFilePath(string $file_path): self
    {
        $this->file_path = $file_path;
        $this->file_name = $this->getFileName();
        $this->file_extension = $this->getFileExtension();
        $this->file_mime_type = $this->getFileMimeType();
        $this->extractor_collection = collect(app()->tagged('extractors'));
        $this->supported_file_extensions = (clone $this->extractor_collection)
            ->transform(function (AbstractTextExtractor $extractor) {
                return $extractor->supported_extension;
            })
            ->flatten()
            ->toArray();
        return $this;
    }

    /**
     * Get the file path
     * @return string
     * @throws TextractException
     */
    public function getFilePath(): string
    {
        if ($this->fileIsExists()) {
            return $this->file_path;
        }
        throw new TextractException(trans('textract::file.error_not_exists', ['path' => $this->file_path]));
    }

    /**
     * Is the extractable file exists/file path is valid or not
     * @return bool
     */
    protected function fileIsExists(): bool
    {
        if (isset($this->file_path)) {
            return file_exists($this->file_path);
        }
        return false;
    }

    /**
     * Get the extractor
     * @return AbstractTextExtractor
     * @throws TextractException
     */
    public function getExtractor(): AbstractTextExtractor
    {
        if (isset($this->file_mime_type)) {
            $selected_extractor =  (clone $this->extractor_collection)
                ->filter(function (AbstractTextExtractor $extractor) {
                    return in_array($this->file_extension, $extractor->supported_extension, true);
                });
            if ($selected_extractor->count() > 0) {
                return $selected_extractor->first();
            }
            throw new TextractException(
                "Invalid file format. Only support ".
                implode('/', $this->supported_file_extensions).
                " files"
            );
        }
        throw new TextractException("Please provide a file to extract text from that.");
    }

    /**
     * Get the file name from the file path
     * @return string|null
     */
    public function getFileName(): ?string
    {
        if (isset($this->file_path)) {
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
        if (isset($this->file_path)) {
            return strtolower(pathinfo($this->file_path, PATHINFO_EXTENSION));
        }
        return null;
    }

    /**
     * Get file mime type from the file
     * @return string|null
     */
    public function getFileMimeType(): ?string
    {
        if (isset($this->file_path)) {
            return mime_content_type($this->file_path);
        }
        return null;
    }

    /**
     * @param PdfOptions $options
     * @return $this
     */
    public function setPdfOptions(PdfOptions $options): self
    {
        $this->pdf_options = $options;
        return $this;
    }

    /**
     * @return PdfOptions|null
     */
    public function getPdfOptions(): ?PdfOptions
    {
        return $this->pdf_options;
    }
}
