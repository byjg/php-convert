# Convert

[![Opensource ByJG](https://img.shields.io/badge/opensource-byjg.com-brightgreen.svg)](http://opensource.byjg.com)
[![Build Status](https://travis-ci.com/byjg/convert.svg)](https://travis-ci.com/byjg/convert)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8e4f8746-cfd9-4ad7-82e8-531cf4de2461/mini.png)](https://insight.sensiolabs.com/projects/8e4f8746-cfd9-4ad7-82e8-531cf4de2461)

A lightweight utility for string conversion between text from UTF8 to a lot of formats and vice-versa.

## Examples

```php
<?php
$str = \ByJG\Convert\ToUTF8::fromHtmlEntities('Jo&atilde;o');
echo $str; // João

$str2 = \ByJG\Convert\FromUTF8::toHtmlEntities('João');
echo $str2; // Jo&atilde;o

$str3 = \ByJG\Convert\FromUTF8::removeAccent('João');
echo $str3; // Joao

$str4 = \ByJG\Convert\FromUTF8::toIso88591Email('João');
echo $str4; // =?iso-8859-1?Q?Jo=E3o?=

$str5 = \ByJG\Convert\FromUTF8::onlyAscii('Joãoﾠ');
echo $str5; // Joao

// https://en.wikipedia.org/wiki/Combining_character
$str6 = \ByJG\Convert\ToUTF8::fromCombiningChar($combining);
echo $str6;
```

## Install

Just type:

```bash
composer install "byjg/convert=5.0.*"
```

## Running Tests

```bash
vendor/bin/phpunit
```
