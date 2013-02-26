EDownloadHelper
===============

This extension is a helper for file downloads with resume, download speed and stream options.

**Tested only on Apache with DownthemAll FireFox plugin.

<div class="info">
I have created a GitHub repository for those willing to contribute on any of the extensions I created. Please, check the link at the bottom of this wiki. <br/><br/>
</div>

##ChangeLog
- 2011-01-29 Fixed "ob_flush(): failed to flush buffer. No buffer to flush." (  [Rangel Reale](http://www.yiiframework.com/forum/index.php?/user/3582-rangel-reale/ "Rangel Reale"))
- 2011-01-25 Bugs Fixed -headers were not correctly printed

##Requirements

Developed with Yii version 1.1.6

##Usage

Download and extract the extension on your protected/extensions folder. The extension will be under a folder named 'helpers'.

The extension just have one static method and static property array that holds file extensions to be streamed. It use is quite straightforward:

**NOTE**: On the comments within the extension there is a DS reference that is a shortcut to DIRECTORY_SEPARATOR. Please, use as the following below:
~~~
[php]
// Import library ( assuming in protected.extensions.helpers)
Yii::import('ext.helpers.EDownloadHelper');

// assumming I have a folder named docs under my webroot folder
// and a file to be downloaded 'myhugefile.zip'
EDownloadHelper::download(Yii::getPathOfAlias('webroot.docs').DIRECTORY_SEPARATOR.'myhugefile.zip');
~~~

##Resources
 * [Project page](http://www.ramirezcobos.com/)
 * [Yii Forum Post](http://www.yiiframework.com/forum/index.php?/topic/15601-edownloadhelper/)