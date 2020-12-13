<?php

namespace App;

require_once 'autoload.php';

use App\Model\User;
use App\Model\Discussion;
use App\Model\Message;
use function App\Utils\dump;

$bobby = new User('bobby', 'myPassword', 'Bob');

dump($bobby);