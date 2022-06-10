## PHP Textract
A laravel 9 package to extract text from files. This work is ispired by ["textract node"](https://www.npmjs.com/package/textract).

### Supported file formats
Following file formats is supported currently. You need to install proper extensions
to your server to work with all the following extension related files. The package will 
check file content MIME type before execute. So with the extension you have maintain
the current content type to work this package-
- HTML
- TEXT
- DOC
- DOCX
- XLS, XLSX, XLSM, XLTX, XLTM, XLT
- CSV
- PDF
- Image
  - Jpeg
  - Pdf
- ODT
- ODS
- RTF

### Install
``` 
composer require nilgems/php-textract
```
### Configuration
You don't need to anything special for your laravel application to work with this
package.
### Example
Use the ```Nilge\Textract\Textract``` facade to run the extractor. 
```
Textract::run(string $file_path, [string $job_id],[array $extra_data]);
```
##### Example 1: 
You can extract text from supported file format.

I want to recommend you to use the extractor in [Laravel Queue Job]() from better performance. In PHP there have a limitation of maximum execution time and maximum memory limit, in queue the process will run in background via CLI and you can set unlimited(-1) ```max_execution_time``` and unlimited(-1) ```max_memory_limit```;
```
........
use Nilge\Textract\Textract;

Route::get('/textract', function(){
    $file_path = ...;
    return Textract::run($file_path);
});
........
```

##### Example 2:
If you need to specify languages in image file for better extraction output from image file.
```
........
use Nilge\Textract\Textract;

Route::get('/textract', function(){
    $image_file_path = ...;
    return Textract::run($file_path, null, [
      'lang' => ['eng', 'jpn', 'spa']
    ]);
});
........
```
### Dependencies
- To enable the image extraction feature you need to install [Tesseract OCR](https://github.com/tesseract-ocr/tesseract)
- To enable the PDF extraction feature you need to install [pdftotext](http://www.xpdfreader.com/download.html)
- To work properly, your server must have following php extensions installed -
  - ext-fileinfo
  - ext-zip
  - ext-gd or ext-imagick
  - ext-xml
#### Tesseract OCR Installation
- Ubuntu
  - Update the system: ```sudo apt update```
  - Add Tesseract OCR 5 PPA to your system: ```sudo add-apt-repository ppa:alex-p/tesseract-ocr-devel```
  - Install Tesseract on Ubuntu 20.04 | 18.04: ```sudo apt install -y tesseract-ocr```
  - Once installation is complete update your system: ```sudo apt update```
  - Verify the installation: ```tesseract --version```
- Windows
  - There are many [ways](https://github.com/tesseract-ocr/tesseract/wiki#windows) to install [Tesseract OCR](https://github.com/tesseract-ocr/tesseract) on your system, but if you just want something quick to get up and running, I recommend installing the [Capture2Text](https://chocolatey.org/packages/capture2text) package with [Chocolatey](https://chocolatey.org/). 
  - Choco installation: ```choco install capture2text --version 5.0```

  **Note: Recent versions of [Capture2Text](https://chocolatey.org/packages/capture2text) stopped shipping the ```tesseract``` binary**

#### PdfToText Installation
- Ubuntu
  - Update the system: ```sudo apt update```
  - Install PdfToText on Ubuntu 20.04 | 18.04: ```sudo apt-get install poppler-utils```
  - Verify the installation: ```pdftotext -v```
- Windows
  - Sorry but ```pdftotext``` available via [poppler](https://poppler.freedesktop.org/) and the [poppler](https://poppler.freedesktop.org/) is not available yet for windows. But you can install and [use the library by windows linux sub-system WLS](https://towardsdatascience.com/poppler-on-windows-179af0e50150). Alternatively, you can install [Laravel Homestead](https://laravel.com/docs/9.x/homestead) in your project and using vagrant virtualization you can run the project in ubuntu virtual server. 