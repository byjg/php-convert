<?php
require_once __DIR__ . "/_base.php";

$lines = preg_split('/\n/', $var);

$i = 1;
$str1 = "";
$str2 = "";
foreach ($lines as $line) {
    $reg = preg_split('/\t/', $line);
    $deli = " ";

    if ($i++ % 10 == 0) {
        $deli = " \n";
    }

    $str1 .= $reg[0] . $deli;
    $str2 .= $reg[1] . $deli;
}

echo "'" . implode("'\n . '", preg_split("~\n~", $str1)) . "\n\n";
echo "'" . implode("'\n . '", preg_split("~\n~", $str2)) . "\n\n";
