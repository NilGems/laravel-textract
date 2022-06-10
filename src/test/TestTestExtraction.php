<?php

namespace Nilgems\PhpTextract\test;

class TestTestExtraction
{
    public const TEST_FILES = [
        'doc' => __DIR__ . '/../../storage/example.doc',
        'docx' => __DIR__ . '/../../storage/example.docx',
        'xls' => __DIR__ . '/../../storage/example.xls',
        'xlsx' => __DIR__ . '/../../storage/example.xlsx',
        'ods' => __DIR__ . '/../../storage/example.ods',
        'rtf' => __DIR__ . '/../../storage/example.rtf',
        'odt' => __DIR__ . '/../../storage/example.odt',
        'pdf' => __DIR__ . '/../../storage/example.pdf',
        'text' => __DIR__ . '/../../storage/example.txt',
        'img' => __DIR__ . '/../../storage/example.png',
        'img_i18' => __DIR__ . '/../../storage/example-multi-languages.png',
    ];

    public function process()
    {
    }
}
