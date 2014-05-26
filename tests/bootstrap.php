<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('Cubalider\Test\Component\Mobile', __DIR__);

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));