<?php

namespace AWSM\LibWP\Examples\Component;

require '../../vendor/autoload.php';

use AWSM\LibWP\Component\Component;

/**
 * My Component
 */
class MyComponent Extends Component {
    // Does not need anything, only extended class Component is needed in this directory.
}

// To add anywhere else.
$component = new MyComponent();
$component->run();