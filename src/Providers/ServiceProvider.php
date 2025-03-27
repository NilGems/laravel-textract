<?php

namespace Nilgems\PhpTextract\Providers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Nilgems\PhpTextract\ExtractorService\Extractors\HtmlExtractor;
use Nilgems\PhpTextract\ExtractorService\Extractors\ImageExtractor;
use Nilgems\PhpTextract\ExtractorService\Extractors\MsOfficeDocExtractor;
use Nilgems\PhpTextract\ExtractorService\Extractors\MsOfficeDocxExtractor;
use Nilgems\PhpTextract\ExtractorService\Extractors\MsOfficePptxExtractor;
use Nilgems\PhpTextract\ExtractorService\Extractors\OpenOfficeDocument;
use Nilgems\PhpTextract\ExtractorService\Extractors\OpenOfficeSpreadSheet;
use Nilgems\PhpTextract\ExtractorService\Extractors\PdfExtractor;
use Nilgems\PhpTextract\ExtractorService\Extractors\RtfExtractor;
use Nilgems\PhpTextract\ExtractorService\Extractors\TxtExtractor;
use Nilgems\PhpTextract\Services\ConsoleExtractionService;
use Nilgems\PhpTextract\Services\ExtractService;
use Nilgems\PhpTextract\Services\UtilsService;

class ServiceProvider extends IlluminateServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'textract');
        $this->publishes([
            __DIR__ . '/../../config/textract.php' => config_path('textract.php')
        ], 'textract');
    }

    /**
     * Register services
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/textract.php', 'textract');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'textract');

        $this->app->bind(UtilsService::class);
        $this->app->bind('textract', ExtractService::class);
        $this->app->bind(ConsoleExtractionService::class);

        $this->registerExtractors();
    }

    /**
     * Register extractors to the application
     * @return void
     */
    protected function registerExtractors(): void
    {
        $extractors = [
            HtmlExtractor::class,
            ImageExtractor::class,
            MsOfficeDocExtractor::class,
            MsOfficeDocxExtractor::class,
            MsOfficePptxExtractor::class,
            OpenOfficeDocument::class,
            OpenOfficeSpreadSheet::class,
            PdfExtractor::class,
            RtfExtractor::class,
            TxtExtractor::class
        ];
        foreach ($extractors as $extractor) {
            $this->app->bind($extractor);
        }

        $this->app->tag($extractors, 'extractors');
    }
}
