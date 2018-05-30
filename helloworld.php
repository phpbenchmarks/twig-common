<?php

$twig = new Twig_Environment(
    new Twig_Loader_Filesystem(__DIR__ . '/templates'),
    ['cache' => $cacheDir]
);

$twig->display('helloworld.html.twig');
