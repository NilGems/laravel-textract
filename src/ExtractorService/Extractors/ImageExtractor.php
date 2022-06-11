<?php

namespace Nilgems\PhpTextract\ExtractorService\Extractors;

use Nilgems\PhpTextract\ExtractorService\Contracts\AbstractTextExtractor;
use Nilgems\PhpTextract\ExtractorService\Ocr\Contracts\TesseractOcrOptions;
use Nilgems\PhpTextract\ExtractorService\Ocr\TesseractOcrRun;

class ImageExtractor extends AbstractTextExtractor
{
    protected array $supported_mime_types = [
        'image/jpeg',
        'image/gif',
        'image/png'
    ];

    public array $supported_extension = [
        'jpg',
        'jpeg',
        'png',
        'gif'
    ];

    protected ?TesseractOcrOptions $ocrOptions = null;

    /**
     * @param TesseractOcrOptions $ocrOptions
     * @return $this
     */
    public function setOcrOptions(TesseractOcrOptions $ocrOptions): self
    {
        $this->ocrOptions = $ocrOptions;
        return $this;
    }

    /**
     * @return string
     * @throws \Nilgems\PhpTextract\Exceptions\TextractException
     * @throws \thiagoalessio\TesseractOCR\TesseractOcrException
     */
    protected function getExtractedText(): string
    {
        return app(TesseractOcrRun::class)
            ->boot($this->utilsService, $this->ocrOptions);
    }
}
