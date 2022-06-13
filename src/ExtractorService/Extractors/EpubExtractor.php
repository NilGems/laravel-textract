<?php

namespace Nilgems\PhpTextract\ExtractorService\Extractors;

use Html2Text\Html2Text;
use lywzx\epub\EpubParser;
use Nilgems\PhpTextract\Exceptions\TextractException;
use Nilgems\PhpTextract\ExtractorService\Contracts\AbstractTextExtractor;
use PhpOffice\PhpWord\Shared\ZipArchive;

class EpubExtractor extends AbstractTextExtractor
{
    protected array $supported_mime_types = [
        'application/epub+zip'
    ];

    public array $supported_extension = ['epub'];

    /**
     * Get extracted text
     * @throws \Nilgems\PhpTextract\Exceptions\TextractException
     * @throws \Exception
     */
    protected function getExtractedText(): string
    {
        if ($zip_path = $this->utilsService->getFilePath()) {
            try {
                $zip = new ZipArchive();
                $zip->open($zip_path);
                $epub = (new EpubParser($this->utilsService->getFilePath()));
                $epub->parse();
                $data = [];
                foreach ($epub->getTOC() as $chapter) {
                    $data[] = trim((new Html2Text($zip->getFromName($chapter['file_name'])))->getText());
                }
                $zip->close();
                return (string) implode("\n", $data);
            } catch (\Exception $exception) {
                report($exception);
                throw new TextractException('The extractor unable to parse the \'epub\' file.');
            }
        }
        return "";
    }
}
