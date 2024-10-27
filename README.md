# Convert

[![Build Status](https://github.com/byjg/php-convert/actions/workflows/phpunit.yml/badge.svg?branch=master)](https://github.com/byjg/php-convert/actions/workflows/phpunit.yml) 
[![Opensource ByJG](https://img.shields.io/badge/opensource-byjg-success.svg)](http://opensource.byjg.com)
[![GitHub source](https://img.shields.io/badge/Github-source-informational?logo=github)](https://github.com/byjg/php-convert/) 
[![GitHub license](https://img.shields.io/github/license/byjg/php-convert.svg)](https://opensource.byjg.com/opensource/licensing.html) 
[![GitHub release](https://img.shields.io/github/release/byjg/php-convert.svg)](https://github.com/byjg/php-convert/releases/)

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

$str5 = \ByJG\Convert\FromUTF8::onlyAscii('João');
echo $str5; // Joao

// https://en.wikipedia.org/wiki/Combining_character
$str6 = \ByJG\Convert\ToUTF8::fromCombiningChar($combining);
echo $str6;
```

## Install

Just type:

```bash
composer install "byjg/convert"
```

## Running Tests

```bash
vendor/bin/phpunit
```

## Dependencies

```mermaid  
flowchart TD  
    byjg/convert  
```

----  
[Open source ByJG](http://opensource.byjg.com)
