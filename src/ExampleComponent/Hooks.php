<?php

use AWSM\SystemLayer\MyClass;
use AWSM\SystemLayer\WP\Action;
use AWSM\SystemLayer\WP\Hooks;

Hooks::instance()
    ->add( new Action('wp_footer', [ MyClass::class, 'footer' ] ) );