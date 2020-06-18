<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$twig = new Environment(
    new FilesystemLoader(__DIR__ . '/templates'),
    ['cache' => $cacheDir]
);

$twig->display('helloworld.html.twig');
