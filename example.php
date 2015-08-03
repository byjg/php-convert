<?php

require "vendor/autoload.php";

$str = \ByJG\Convert\ToUTF8::fromHtmlEntities('Jo&atilde;o');
echo $str; // João

$str2 = \ByJG\Convert\FromUTF8::toHtmlEntities('João');
echo $str2; // Jo&atilde;o

$str3 = \ByJG\Convert\FromUTF8::removeAccent('João');
echo $str3; // Joao

$str4 = \ByJG\Convert\FromUTF8::toIso88591Email('João');
echo $str4; // =?iso-8859-1?Q?Jo=E3o?=

