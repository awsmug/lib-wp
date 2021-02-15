<?php

namespace AWSM\LibWP\Examples\Plugin\Components\HelloWorld;

require '../../vendor/autoload.php';

use AWSM\LibWP\Component\Component;

/**
 * Hello World Component
 * 
 * @since 1.0.0
 */
class HelloWorld Extends Component {
    /**
     * Filter title.
     * 
     * @since 1.0.0
     */
    public function filterTitle() {
        return 'This is my title';
    }
}