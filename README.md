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
composer require nilgems/textract:^0.1
```
### Configuration
You don't need to anything special for your laravel application to work with this
package.

### Example
Use the use ```Nilge\Textract\Textract``` facade to run the extractor. 

Example 1: 
```
........
use Nilge\Textract\Textract;

Route::get('/textract', function(){
    return Textract::run({file_path});
});
........
```

Example 2:

### Dependencies
