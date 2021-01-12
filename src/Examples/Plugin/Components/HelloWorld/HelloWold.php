<?php

namespace AWSM\LibWP\Examples\Plugin\Components\HelloWorld;

require '../../vendor/autoload.php';

use AWSM\LibWP\Component\Component;
use AWSM\LibWP\WP\Hooks\Hooks;

/**
 * Hello World Component
 * 
 * @since 1.0.0
 */
class HelloWorld Extends Component {

    public function __construct()
    {   
        Hooks::instance()->assign( $this );
    }

    /**
     * Filter title.
     * 
     * @since 1.0.0
     */
    public function filterTitle() {
        return 'This is my title';
    }
}