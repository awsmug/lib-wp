<?php

namespace AWSM\LibWP\Examples\Component;

use AWSM\LibWP\Examples\App\Main;
use AWSM\LibWP\WP\Hooks\Action;
use AWSM\LibWP\WP\Hooks\Hooks;

Hooks::instance()
    ->add( new Action( 'wp_head',   array( Main::class, 'logo' ) ) )
    ->add( new Action( 'wp_footer', array( Main::class, 'address' ) ) );