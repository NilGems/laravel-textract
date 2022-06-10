<?php

namespace Nilgems\PhpTextract\Providers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Nilgems\PhpTextract\Console\TextractCommand;
use Nilgems\PhpTextract\Extractor\DocExtractor;
use Nilgems\PhpTextract\Extractor\DocxExtractor;
use Nilgems\PhpTextract\Extractor\ImageExtractor;
use Nilgems\PhpTextract\Extractor\OdtExtractor;
use Nilgems\PhpTextract\Extractor\RtfExtractor;
use Nilgems\PhpTextract\Extractor\TxtExtractor;
use Nilgems\PhpTextract\Extractor\XlsExtractor;
use Nilgems\PhpTextract\Extractor\PdfExtractor;
use Nilgems\PhpTextract\Services\ExtractService;
use Nilgems\PhpTextract\Services\UtilsService;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Extractors available in plugin
     */
    public CONST EXTRACTORS = [
        'pdf' => PdfExtractor::class,
        'doc' => DocExtractor::class,
        'docx' => DocxExtractor::class,
        'rtf' => RtfExtractor::class,
        'xls' => XlsExtractor::class,
        'odf' => OdtExtractor::class,
        'txt' => TxtExtractor::class,
        'img' => ImageExtractor::class
    ];

    public function boot(): void {
        $this->publishes([
            __DIR__ . '/../../config/textract.php' => config_path('textract.php')
        ]);
    }

    /**
     * Register services
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(UtilsService::class);
        $this->app->bind('textract', ExtractService::class);

        $this->registerExtractors();
        $this->commands([ TextractCommand::class ]);
    }

    /**
     * Register extractors to the application
     * @return void
     */
    protected function registerExtractors(): void
    {
        foreach (self::EXTRACTORS as $extractor_id => $extractor_class) {
            $this->app->bind('extractor-' . $extractor_id, $extractor_class);
        }
        $this->app->tag(array_keys(self::EXTRACTORS), 'extractors');
    }
}
