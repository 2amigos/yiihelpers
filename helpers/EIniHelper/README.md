EIniHelper
==========
***Ini Files Parser Helper Class***

This simple class may help you to use .INI files on your projects.

##Requirements

Developed with Yii 1.1.6

##Usage

Unzip the contents on the package onto your protected/extensions folder. The package has a sample .INI file for testing purposes named settings.ini. For the sake of the example, I assume you have that file.

~~~
[php]
// Import the library
Yii::import('ext.helpers.EIniHelper');

// path reference to the .INI file
$ini = Yii::getPathOfAlias('ext.helpers').DIRECTORY_SEPARATOR.'settings.ini';

// Load the whole section (please review the example .INI file)
// The static Load method has Singleton functionality
// so only one instance per file is always maintained
$iniF = EIniHelper::Load($ini)->Get('Database');

// echo one of the values
echo $iniF['database'].'<br/>';

// We can also load a single parameter
$iniF = EIniHelper::Load($ini)->Get('Database','dbtype');

echo $iniF.'<br/>';

// Load
$iniF = EIniHelper::Load($ini)->Get('Parameters','webmaster');

echo $iniF.'<br/>';
~~~

##Resources

 * [Project page](http://www.ramirezcobos.com)
 * [Forum Post](http://www.yiiframework.com/forum/index.php?/topic/16278-extension-einihelper/)

##Change Log
##1.0
- 14-02-2011 Initial public release
