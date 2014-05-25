<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('Muchacuba\Test\Component\Mobile', __DIR__);

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));