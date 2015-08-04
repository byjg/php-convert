# Convert
[![Build Status](https://travis-ci.org/byjg/convert.svg)](https://travis-ci.org/byjg/convert)

## Description

A lightweight utility for string conversion between text from UTF8 to a lot of formats and vice-versa. 

## Examples

```
$str = \ByJG\Convert\ToUTF8::fromHtmlEntities('Jo&atilde;o');
echo $str; // João

$str2 = \ByJG\Convert\FromUTF8::toHtmlEntities('João');
echo $str2; // Jo&atilde;o

$str3 = \ByJG\Convert\FromUTF8::removeAccent('João');
echo $str3; // Joao

$str4 = \ByJG\Convert\FromUTF8::toIso88591Email('João');
echo $str4; // =?iso-8859-1?Q?Jo=E3o?=
``` 

## Install

Just type: `composer install "byjg/convert=~1.0"`

## Running Tests

```bash
cd tests
phpunit -v --bootstrap bootstrap.php .
```
