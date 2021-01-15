<?php

namespace AWSM\LibWP\Examples\Plugin\Components\HelloWorld;

use AWSM\LibWP\Examples\Plugin\MyPlugin;
use AWSM\LibWP\WP\Hooks\Action;

MyPlugin::instance()->hooks
    ->add( new Action( 'wp_title',   array( HelloWorld::class, 'filterTitle' ) ) );