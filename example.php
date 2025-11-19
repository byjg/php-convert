<?php

require "vendor/autoload.php";

$str = \ByJG\Convert\ToUTF8::fromHtmlEntities('Jo&atilde;o');
echo $str; // João

$str2 = \ByJG\Convert\FromUTF8::toHtmlEntities('João');
echo $str2; // Jo&atilde;o

$str3 = \ByJG\Convert\FromUTF8::removeAccent('João');
echo $str3; // Joao

$str4 = \ByJG\Convert\FromUTF8::toMimeEncodedWord('João');
echo $str4; // =?utf-8?Q?Jo=C3=A3o?= (MIME encoding for email headers with non-ASCII chars)

