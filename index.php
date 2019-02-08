<?php

namespace App;

use App\TicTacToe;

spl_autoload_register(function ($class) {
    include __DIR__ . DIRECTORY_SEPARATOR . $class . '.php';
});

$app = new TicTacToe();
$app->run();

