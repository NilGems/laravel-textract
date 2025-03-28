<?php

return [

    /*
     | -----------------------------------------------------------------------------------------------------------------
     |  OCR configurations
     | -----------------------------------------------------------------------------------------------------------------
     |
     | Textract is using "Tesseract OCR" for OCR operations.
     | You can customize the OCR configuration form here. Generally don't need to change the configuration,
     | if you feel to do that please check the "Tesseract OCR"  documents before do any changes.
     | To know more details you can visit - https://github.com/thiagoalessio
     |
     */
    'ocr' => [
        /*
         | -------------------------------------------------------------------------------------------------------------
         |  OCR enabled or disabled:
         | -------------------------------------------------------------------------------------------------------------
         |
         |
         | Enable or disable the OCR functionality here. By default, the OCR is enabled and the code will check the plugin
         | is already installed or not in your server before do any operation. If the plugin is not installed/disabled the image
         | file extraction will not work.
         |
         */
        'enabled' => env('TEXTRACT_OCR_ENABLED', true),
        /*
         | -------------------------------------------------------------------------------------------------------------
         | OCR custom executable path
         | -------------------------------------------------------------------------------------------------------------
         |
         | For more details please visit - https://github.com/thiagoalessio/tesseract-ocr-for-php#executable
         |
         */
        'executable_path' => env('TEXTRACT_OCR_EXEC_PATH', 'tesseract'),

        /*
         | -------------------------------------------------------------------------------------------------------------
         |  OCR inducing recognition
         | -------------------------------------------------------------------------------------------------------------
         |
         |
         | By default, the value is 'null' and OCR will automatically recognise the text and try to extract whole text.
         | If you defined the path, the OCR will be able to extract those text that will match with the patterns inside
         | the text file.
         |
         |
         | Pattern example you can write inside the text file:
         | 1-\d\d\d-GOOG-441
         | www.\n\\\*.com
         |
         | For more details please visit - https://github.com/thiagoalessio/tesseract-ocr-for-php#inducing-recognition
         |
         */
        'text_patterns_path' => env('TEXTRACT_OCR_TEXT_PATTERNS_PATH', null),

        /*
         | -------------------------------------------------------------------------------------------------------------
         |  OCR thread limit
         | -------------------------------------------------------------------------------------------------------------
         |
         |
         | The value of limit will be a integer value. 0 - Mean all available thread.
         | For more details please visit - https://github.com/thiagoalessio/tesseract-ocr-for-php#thread-limit
         |
         */
        'thread_limit' => env('TEXTRACT_OCR_THREAD_LIMIT', 0),

        /*
         | -------------------------------------------------------------------------------------------------------------
         |  OCR custom dictionary text file path.
         | -------------------------------------------------------------------------------------------------------------
         |
         |
         | By default, the value is 'null'
         | Fore more details pleases visit - https://github.com/thiagoalessio/tesseract-ocr-for-php#userpatterns
         |
         */
        'text_dictionary_path' => env('TEXTRACT_OCR_TEXT_DICTIONARY_PATH', null),

         /*
          |-------------------------------------------------------------------------------------------------------------
          | OCR other custom configurations
          |-------------------------------------------------------------------------------------------------------------
          |
          |
          | For more details please visit - https://github.com/thiagoalessio/tesseract-ocr-for-php#other-options
          |
         */
        'config' => [],

        /*
         |-------------------------------------------------------------------------------------------------------------
         | OCR Temporary file storage directory
         |-------------------------------------------------------------------------------------------------------------
         |
         | OCR custom temporary folder storage path. Make sure the path have proper permissions to access by PHP.
         */
        'temp_dir' => null
    ]

];
