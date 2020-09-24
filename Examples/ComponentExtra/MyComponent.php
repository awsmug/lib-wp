<?php

namespace AWSM\LibWP\Examples\ComponentExtra;

require '../../vendor/autoload.php';

use AWSM\LibWP\Component\Component;

/**
 * My Component
 */
class MyComponent Extends Component {
    public function __construct()
    {
        // Some extra configuration
        $this->setup(
            'MyApp.php',
            'MyHooks.php',
            'MyAssets.php'
        );
    }
}

// To add anywhere else.
$component = new MyComponent();
$component->run();