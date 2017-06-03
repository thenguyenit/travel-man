<?php

/**
 * Register The Auto Loader
 */
require __DIR__ . '/bootstrap/autoload.php';

/**
 * Run The Application
 */
$app = new \App\Kernel();
$app->handle();