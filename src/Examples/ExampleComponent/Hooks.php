<?php

use AWSM\LibWP\WP\Hooks\Action;
use AWSM\LibWP\WP\Hooks\Hooks;

Hooks::global()
    ->add( new Action('wp_footer', [ MyClass::class, 'footer' ] ) );