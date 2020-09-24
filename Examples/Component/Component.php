<?php

require '../../vendor/autoload.php';

use AWSM\LibWP\Component\Component;

$component = new Component();
$component->setup(
    'MyApp.php',
    'MyHooks.php',
    'MyAssets.php'
);
$component->run();