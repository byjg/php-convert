<?php

require_once __DIR__ . "/_base.php";

$lines = preg_split('/\n/', $var);

$result = [];

foreach ($lines as $line) {
    $reg = preg_split('/\t/', $line);

    $char = [];
    for($i=0; $i<strlen($reg[0]); $i++) {
        $char[] = ord($reg[0][$i]);
    }

    if (count($char) < 2) {
        continue;
    }

    $text = "'" . $reg[1] . "'  /* " . $reg[0] . " (" . $reg[3] . ") */,\n";
    if (count($char) == 2) {
        $result[$char[0]][$char[1]] =  $text;
    }
    if (count($char) == 3) {
        $result[$char[0]][$char[1]][$char[2]] =  $text;
    }
}

foreach ($result as $keyL1 => $valL1) {
    echo $keyL1 . " => [\n";
    foreach ($valL1 as $keyL2 => $valL2) {
        if (!is_array($valL2)) {
            echo "    $keyL2 => $valL2";
        } else {
            echo "    $keyL2  => [\n";
            foreach ($valL2 as $keyL3 => $valL3) {
                echo "        $keyL3 => $valL3";
            }
            echo "    ],\n";
        }
    }
    echo "],\n";
}

