[![Packagist](https://img.shields.io/packagist/v/nilgems/laravel-textract)](https://packagist.org/packages/nilgems/laravel-textract)
# Laravel Textract
A [Laravel](https://laravel.com) package to extract text from files like DOC, Excel, Image, Pdf and more.

# Versions and compatibility

- [Laravel 8](https://laravel.com) or higher is required.
- [Php 7.4]() or higher is required

### <img src="./blobs/danger.png?raw=true" alt="Note" width="18"> [Laravel 9](https://laravel.com) support is added.

### Supported file formats
Following file formats is supported currently. You need to install proper extensions
to your server to work with all the following extension related files. The package will
check file content MIME type before execute.
- **HTML**
- **TEXT**
- **DOC**
- **DOCX**
- **XLS**, **XLSX**, **XLSM**, **XLTX**, **XLTM**, **XLT**
- **CSV**
- **PDF**
- **Image**
    - _jpeg_
    - _png_
- **ODT**
- **ODS**
- **RTF**

<img src="./blobs/warning.png?raw=true" alt="Note" width="12">***GIF*** and ***PPT*** support is under development.

**We are working hard to make this laravel plugin useful. If you found any issue please add a post on discussion.**

### Installation

``` 
composer require nilgems/laravel-textract
```
Once installed you can do stuff like this:
```
# Run the extractor
$output = Textract::run('/path/to/file.extension');

# Display the extracted text
echo $output->text;

# Display the extracted text word count
echo $output->word_count;

# Display the extracted text with direct string conversion
echo (string) $output;
```
Run the extractor to any supported file:
```
Textract::run(string $file_path, [string $job_id],[array $extra_data]);
```
|   Option    |  Type  |   Default value    | Required |                                                                                    Description                                                                                     |
|:-----------:|:------:|:------------------:|:--------:|:----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------:|
| $file_path  | String | _No default value_ |   Yes    |                                                                        Text extractable file absolute path.                                                                        |
|   $job_id   | String |     ```NULL```     |    No    |                                  It's a optional parameter. Extraction **job id**. If this option is blank the plugin will auto create the **ID**                                  |
| $extra_data | array  |         []         |    No    | It's a optional parameter. To pass extra parameter. If you are extracting a image file, you can mention languages by this **parameter**. ``` ['lang' => ['eng', 'jpn', 'spa']] ``` |

### Configuration

- You can add **provider** in ```app.php``` under the ```config``` folder of your
  [Laravel](https://laravel.com) project. It's optional, the package automatically load the service provider in your application.
  ```
  'providers' => [
    ...
    Nilgems\PhpTextract\Providers\ServiceProvider,
    ...
  ]
  ```
- Add **alias** in ```app.php``` under the ```config``` folder of your
  [Laravel](https://laravel.com) project. It's optional, the package automatically load the ```facade``` in your application.
  ```
  'aliases' => [
    ...
    'Textract' => Nilgems\PhpTextract\Textract::class,
    ...
  ]
  ```
### Example

##### Example 1:
You can extract text from supported file format.

It is recommended to use the extractor with [Laravel Queue Job](https://laravel.com/docs/9.x/queues#creating-jobs) from better performance. <br /><br />
In ```php``` there have a restriction of execution time and memory limit defined in ```php.ini``` file with the option ```max_execution_time``` and ```memory_limit```. If file size is big, the process may kill forcefully when exceed the limit. You can use ```queue - database/redis``` or ```Laravel horizon``` to run the process in background.
```
........
Route::get('/textract', function(){
    return Textract::run('/path/to/image/example.png');
});
........
```

##### Example 2:
If you need to specify languages in image file for better extraction output from image file.
```
........
Route::get('/textract', function(){
    return Textract::run('/path/to/image/example.png', null, [
      'lang' => ['eng', 'jpn', 'spa']
    ]);
});
........
```
### Dependencies
- To enable the image extraction feature you need to install [Tesseract OCR](https://github.com/tesseract-ocr/tesseract)
- To enable the PDF extraction feature you need to install [pdftotext](http://www.xpdfreader.com/download.html)
- To work properly, your server must have following php extensions installed -
    - **ext-fileinfo**
    - **ext-zip**
    - **ext-gd** or **ext-imagick**
    - **ext-xml**
### Tesseract OCR Installation
#### <img src="https://raw.githubusercontent.com/NilGems/laravel-textract/master/blobs/ubuntu.png" width="12"  alt="Ubuntu" /> Ubuntu
- Update the system: ```sudo apt update```
- Add Tesseract OCR 5 PPA to your system: ```sudo add-apt-repository ppa:alex-p/tesseract-ocr-devel```
- Install Tesseract on Ubuntu 20.04 | 18.04: ```sudo apt install -y tesseract-ocr```
- Once installation is complete update your system: ```sudo apt update```
- Verify the installation: ```tesseract --version```
#### <img src="https://raw.githubusercontent.com/NilGems/laravel-textract/master/blobs/windows.png" width="12"  alt="Ubuntu" /> Windows
- There are many [ways](https://github.com/tesseract-ocr/tesseract/wiki#windows) to install [Tesseract OCR](https://github.com/tesseract-ocr/tesseract) on your system, but if you just want something quick to get up and running, I recommend installing the [Capture2Text](https://chocolatey.org/packages/capture2text) package with [Chocolatey](https://chocolatey.org/).
- Choco installation: ```choco install capture2text --version 5.0```

**Note: Recent versions of [Capture2Text](https://chocolatey.org/packages/capture2text) stopped shipping the ```tesseract``` binary**

### PdfToText Installation
#### <img src="https://raw.githubusercontent.com/NilGems/laravel-textract/master/blobs/ubuntu.png" width="12"  alt="Ubuntu" /> Ubuntu
- Update the system: ```sudo apt update```
- Install PdfToText on Ubuntu 20.04 | 18.04: ```sudo apt-get install poppler-utils```
- Verify the installation: ```pdftotext -v```
#### <img src="https://raw.githubusercontent.com/NilGems/laravel-textract/master/blobs/windows.png" width="12"  alt="Ubuntu" /> Windows
- Sorry but ```pdftotext``` available via [poppler](https://poppler.freedesktop.org/) and the [poppler](https://poppler.freedesktop.org/) is not available yet for windows. But you can install and [use the library by windows linux sub-system WLS](https://towardsdatascience.com/poppler-on-windows-179af0e50150). Alternatively, you can install [Laravel Homestead](https://laravel.com/docs/9.x/homestead) in your project and using vagrant virtualization you can run the project in ubuntu virtual server.

## License

[MIT](https://choosealicense.com/licenses/mit/)

---
## 💻 Tech Stack
![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=plastic&logo=css3&logoColor=white) ![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=plastic&logo=php&logoColor=white) ![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=plastic&logo=html5&logoColor=white) ![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=plastic&logo=javascript&logoColor=%23F7DF1E) ![AWS](https://img.shields.io/badge/AWS-%23FF9900.svg?style=plastic&logo=amazon-aws&logoColor=white) ![Vue.js](https://img.shields.io/badge/vuejs-%2335495e.svg?style=plastic&logo=vuedotjs&logoColor=%234FC08D) ![Vuetify](https://img.shields.io/badge/Vuetify-1867C0?style=plastic&logo=vuetify&logoColor=AEDDFF) ![NPM](https://img.shields.io/badge/NPM-%23000000.svg?style=plastic&logo=npm&logoColor=white) ![jQuery](https://img.shields.io/badge/jquery-%230769AD.svg?style=plastic&logo=jquery&logoColor=white) ![Express.js](https://img.shields.io/badge/express.js-%23404d59.svg?style=plastic&logo=express&logoColor=%2361DAFB) ![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=plastic&logo=laravel&logoColor=white) ![NuxtJS](https://img.shields.io/badge/Nuxt-black?style=plastic&logo=nuxt.js&logoColor=white) ![Socket.io](https://img.shields.io/badge/Socket.io-black?style=plastic&logo=socket.io&badgeColor=010101) ![Apache](https://img.shields.io/badge/apache-%23D42029.svg?style=plastic&logo=apache&logoColor=white) ![MariaDB](https://img.shields.io/badge/MariaDB-003545?style=plastic&logo=mariadb&logoColor=white) ![MongoDB](https://img.shields.io/badge/MongoDB-%234ea94b.svg?style=plastic&logo=mongodb&logoColor=white) ![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=plastic&logo=mysql&logoColor=white) ![SQLite](https://img.shields.io/badge/sqlite-%2307405e.svg?style=plastic&logo=sqlite&logoColor=white) ![Inkscape](https://img.shields.io/badge/Inkscape-e0e0e0?style=plastic&logo=inkscape&logoColor=080A13) ![Jira](https://img.shields.io/badge/jira-%230A0FFF.svg?style=plastic&logo=jira&logoColor=white) ![Vagrant](https://img.shields.io/badge/vagrant-%231563FF.svg?style=plastic&logo=vagrant&logoColor=white)

---
[![](https://visitcount.itsvg.in/api?id=NilGems&icon=0&color=0)](https://visitcount.itsvg.in)
