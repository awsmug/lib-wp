<?php

namespace AWSM\LibWP\Examples\Plugin\Components\HelloWorld;

use AWSM\LibWP\WP\Hooks\Action;
use AWSM\LibWP\WP\Hooks\Hooks;

(new Hooks() )
    ->add( new Action( 'wp_title',   array( HelloWorld::class, 'filterTitle' ) ) );