ECurrencyHelper
===============
***Currency Conversion Class based on the European Central Bank daily rates***

###Introduction
After analyzing most of the currency convertors services out there, I realized that no matter which one you use, all conversions are always approximate. Google finance, XE, thecurrencygraph, etc... It doesn't matter, they are all different. Some of them, not named here, claim that they are 100% accurate but that's not true, each Bank has its own interpretation of the rates, and I do understand that, as they make money with our money.

All that research was part of a personal project, a research which end up creating a simple but efficient conversion tool based on the daily rates feed from the official [European Central Bank](http://www.ecb.int/home/html/index.en.html "European Central Bank") (ECB)

The conversion occurs using the EURO rate. That means that if you convert from USD to GBP, USD will be converted to EUR and then to GBP, loosing some accuracy on the way.

##Usage

Unzip the contents of the package and place the file where ever you wish, but for the sake of this example, I assume you move it to your extensions folder.
~~~
[php]
Yii::import('ext.ECurrencyHelper');

$cc = new ECurrencyHelper();

// convert 10 us dollars to euros
echo $cc->convert(ECurrencyHelper::US_DOLLAR, ECurrencyHelper::EUROPEAN_EURO, 10);

// convert 10 chinese yuan renminbi to us dollars
echo $cc->convert(ECurrencyHelper::CHINESE_YUAN_RENMINBI, ECurrencyHelper::US_DOLLAR, 10);

~~~

###Update on Usage
It has been an addition to the extension, now you can use ECB, Yahoo or Google; being ECB and Yahoo the most accurate ones (with Yahoo and Google [you can use most of World Currencies abbreviations](http://en.wikipedia.org/wiki/List_of_circulating_currencies "Circulating Currencies")). Here is an example of use:

~~~
[php]
$cc = new ECurrencyHelper();

echo $cc->convert('USD','EUR',1, ECurrencyHelper::USE_GOOGLE).',';
echo $cc->convert('USD','EUR',1, ECurrencyHelper::USE_YAHOO).',';
echo $cc->convert('USD','EUR',1).'<br/>';

echo $cc->convert('ILS','EUR',1, ECurrencyHelper::USE_GOOGLE).',';
echo $cc->convert('ILS','EUR',1, ECurrencyHelper::USE_YAHOO).',';
echo $cc->convert('ILS','EUR',1);
~~~
**important: the functions **getRates()** and **getRate()** do work only with ECB, which automatically loads the currency rates. Would be nice to do the same with Yahoo and Google, if you guys know how to, let me know.

##Resources
 * [Project page](http://www.ramirezcobos.com/)
 * [European Central Bank](http://www.ecb.int/home/html/index.en.html)
 * [Forum Post](http://www.yiiframework.com/forum/index.php?/topic/23523-ecurrencyhelper/page__p__114527__fromsearch__1#entry114527)
 * [List of World Currencies](http://en.wikipedia.org/wiki/List_of_circulating_currencies)

##Change Log

###version 1.0.2

- Added currencyInfo function to find out about hex symbols of the currencies in the world
- Solved open_basedir restrictions

- Fixed silly mistype bug

###version 1.0.1

- Added yahooConvert and googleConvert functions
- Special thanks to [Aphraoh](http://www.yiiframework.com/forum/index.php?/user/6213-aphraoh/ "Aphraoh") for its contribution with yahooConvert

###version 1.0.0

- Initial Public Release