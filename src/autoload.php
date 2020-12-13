<?php

namespace App;

spl_autoload_register(function ($name) {
    $relativePath = str_replace(__NAMESPACE__ . '\\', '', $name);
    include str_replace('\\', '/', $relativePath) . '.php';
});

require_once 'utils/dev.php';