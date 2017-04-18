<?php
require_once __DIR__ . "/_base.php";

$lines = preg_split('/\n/', $var);

foreach ($lines as $line) {
    $reg = preg_split('/\t/', $line);

    $char = [];
    for($i=0; $i<strlen($reg[0]); $i++) {
        $char[] = ord($reg[0][$i]);
    }
    $inChar = '[' . implode(',', $char) . ']';

    echo "'" . $reg[1] . "' => $inChar   /* " . $reg[0] . " (" . $reg[3] . ") */,\n";
    if (!empty($reg[2])) {
        echo "'" . $reg[2] . "' => $inChar   /* " . $reg[0] . " (" . $reg[3] . ") */,\n";
    }
}
