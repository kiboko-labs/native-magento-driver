<?php

include '/var/www/vendor/autoload.php';
include __DIR__ . '/Manipulator.php';
include __DIR__ . '/KernelManipulator.php';

include '/var/www/app/AppKernel.php';
$classname = 'AppKernel';

$manipulator = new \Kiboko\Manipulator\KernelManipulator($classname);
$manipulator->addBundle('Kiboko\Bundle\MagentoDriverBundle\KibokoMagentoDriverBundle');
