<?php

namespace App\Utils;

function dump(...$args) {
    echo "<pre>";
    foreach ($args as $arg) {
        if (is_array($arg) || is_object($arg)) {
            print_r($arg);
        } else {
            echo $arg;
        }
    }
    echo "</pre>";
}