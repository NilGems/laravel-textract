<?php

namespace Nilgems\PhpTextract\ExtractorService\Contracts;

use Illuminate\Support\Collection;
use Nilgems\PhpTextract\Exceptions\TextractException;
use Nilgems\PhpTextract\Services\UtilsService;

abstract class AbstractExtractor
{
    /**
     * @var string $file_path
     */
    protected string $file_path = "";
    /**
     * @var string $error_message
     */
    protected string $error_message = "The extractor plugin is not installed in the system. Please install and try again.";
    /**
     * ExtractorService name
     * @var string $extractor_name
     */
    protected string $extractor_name = 'The extractor';

    protected array $extractor_supported_extension = [];
    /**
     * @var array $mime_accepts
     */
    protected array $mime_accepts = [];
    /**
     * @var string $current_mime_type
     */
    protected string $current_mime_type = "";
    /**
     * @var Collection $data
     */
    protected Collection $data;

    public function __construct()
    {
        $this->data = new Collection([]);
    }

    /**
     * Set data
     * @param $key
     * @param $value
     * @return $this
     */
    public function setData($key, $value): self
    {
        $this->data->put($key, $value);
        return $this;
    }
    /**
     * Get accept mime types
     * @return array
     */
    public function getAcceptMimeTypes(): array
    {
        if (method_exists($this, 'mimeAccepts')) {
            return $this->mimeAccepts();
        }
        return $this->mime_accepts;
    }

    /**
     * Get acceptable extensions
     * @return array
     */
    public function getAcceptExtensions(): array
    {
        return $this->extractor_supported_extension;
    }
    /**
     * Has match mime type
     * @param string $mime_type
     * @return bool
     */
    public function hasMatchMimeType(string $mime_type): bool
    {
        $acceptable_mime_type = $this->getAcceptMimeTypes();
        if (empty($acceptable_mime_type)) {
            return true;
        }
        return in_array(strtolower($mime_type), $acceptable_mime_type, true);
    }

    /**
     * @param string $file_path
     * @param array $data
     * @return string|null
     * @throws TextractException
     */
    public function boot(string $file_path, array $data = []): ?string
    {
        $this->file_path = $file_path;
        $this->data = $this->data->merge($data);
        $utilsService = app(UtilsService::class)->setFilePath($file_path);
        $utilsService->setFilePath($file_path);
        $this->current_mime_type = $utilsService->getFileMimeType();
        if (!$this->hasMatchMimeType($this->current_mime_type)) {
            throw new TextractException(
                $this->extractor_name .
                ' unable to process the file. Please ensure the content of file is a ' .
                implode('/', $this->extractor_supported_extension) . 'file.'
            );
        }
        $has_valid = $this->checkHaveProviderPackage();
        if ($has_valid) {
            return $this->getTextFromFile();
        }
        throw new TextractException($this->error_message);
    }

    abstract protected function checkHaveProviderPackage();

    abstract protected function getTextFromFile();
}
