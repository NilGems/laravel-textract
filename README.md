## Laravel Textract
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
composer require nilgems/laravel-textract
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

I want to recommend you to use the extractor in [Laravel Queue Job](https://laravel.com/docs/9.x/queues#creating-jobs) from better performance. In PHP there have a limitation of maximum execution time and maximum memory limit, in queue the process will run in background via CLI and you can set unlimited(-1) ```max_execution_time``` and unlimited(-1) ```max_memory_limit```;
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

# 💻Tech Stack
![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=plastic&logo=css3&logoColor=white) ![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=plastic&logo=php&logoColor=white) ![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=plastic&logo=html5&logoColor=white) ![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=plastic&logo=javascript&logoColor=%23F7DF1E) ![AWS](https://img.shields.io/badge/AWS-%23FF9900.svg?style=plastic&logo=amazon-aws&logoColor=white) ![Vue.js](https://img.shields.io/badge/vuejs-%2335495e.svg?style=plastic&logo=vuedotjs&logoColor=%234FC08D) ![Vuetify](https://img.shields.io/badge/Vuetify-1867C0?style=plastic&logo=vuetify&logoColor=AEDDFF) ![NPM](https://img.shields.io/badge/NPM-%23000000.svg?style=plastic&logo=npm&logoColor=white) ![jQuery](https://img.shields.io/badge/jquery-%230769AD.svg?style=plastic&logo=jquery&logoColor=white) ![Express.js](https://img.shields.io/badge/express.js-%23404d59.svg?style=plastic&logo=express&logoColor=%2361DAFB) ![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=plastic&logo=laravel&logoColor=white) ![NuxtJS](https://img.shields.io/badge/Nuxt-black?style=plastic&logo=nuxt.js&logoColor=white) ![Socket.io](https://img.shields.io/badge/Socket.io-black?style=plastic&logo=socket.io&badgeColor=010101) ![Apache](https://img.shields.io/badge/apache-%23D42029.svg?style=plastic&logo=apache&logoColor=white) ![MariaDB](https://img.shields.io/badge/MariaDB-003545?style=plastic&logo=mariadb&logoColor=white) ![MongoDB](https://img.shields.io/badge/MongoDB-%234ea94b.svg?style=plastic&logo=mongodb&logoColor=white) ![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=plastic&logo=mysql&logoColor=white) ![SQLite](https://img.shields.io/badge/sqlite-%2307405e.svg?style=plastic&logo=sqlite&logoColor=white) ![Inkscape](https://img.shields.io/badge/Inkscape-e0e0e0?style=plastic&logo=inkscape&logoColor=080A13) ![Jira](https://img.shields.io/badge/jira-%230A0FFF.svg?style=plastic&logo=jira&logoColor=white) ![Vagrant](https://img.shields.io/badge/vagrant-%231563FF.svg?style=plastic&logo=vagrant&logoColor=white)
# 📊GitHub Stats :
![](https://github-readme-stats.vercel.app/api?username=NilGems&theme=radical&hide_border=false&include_all_commits=false&count_private=false)<br/>
![](https://github-readme-stats.vercel.app/api/top-langs/?username=NilGems&theme=radical&hide_border=false&include_all_commits=false&count_private=false&layout=compact)

---
[![](https://visitcount.itsvg.in/api?id=NilGems&icon=0&color=0)](https://visitcount.itsvg.in)
