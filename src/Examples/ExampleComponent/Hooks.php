<?php

use AWSM\LibWP\WP\Core\Location;
use AWSM\LibWP\WP\Hooks\Action;
use AWSM\LibWP\WP\Hooks\Filter;
use AWSM\LibWP\WP\Hooks\Hooks;

Hooks::instance()
    ->add( new Action( 'wp_footer', [ MyClass::class, 'footer' ] ),       Location::frontend() )
    ->add( new Filter( 'wp_title',  [ MyClass::class, 'filterTitle' ] ),  Location::frontend() );