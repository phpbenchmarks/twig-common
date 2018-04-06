<?php

$twig = new Twig_Environment(
    new Twig_Loader_Filesystem(__DIR__ . '/templates'),
    ['cache' => $cacheDir]
);

echo $twig->render('helloworld.html.twig');
