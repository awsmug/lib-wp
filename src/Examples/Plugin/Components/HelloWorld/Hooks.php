<?php

namespace AWSM\LibWP\Examples\Plugin\Components\HelloWorld;

use AWSM\LibWP\Examples\App\Main;
use AWSM\LibWP\WP\Hooks\Action;
use AWSM\LibWP\WP\Hooks\Hooks;

Hooks::instance()
    ->add( new Action( 'wp_title',   array( HelloWorld::class, 'filterTitle' ) ) );