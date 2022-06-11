<?php

use Nilgems\PhpTextract\Services\ExtractService;
use Nilgems\PhpTextract\Textract;
use PHPUnit\Framework\TestCase;

class ExtractionTest extends TestCase
{
    /**
     * @dataProvider addExtractionData
     */
    public function testExtraction(string $path)
    {
        $output = (new ExtractService())->run($path);
        $this->assertIsInt($output->word_count);
        $this->assertIsString($output->text);
        $this->assertNotEmpty($output->text);
    }

    public function addExtractionData(): array
    {
        return [
            'extracting doc' => [__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'storage/example.xlsx']
        ];
    }
}
