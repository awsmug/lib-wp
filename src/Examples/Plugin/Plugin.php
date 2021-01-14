<?php

/**
 * Plugin Name: My Plugin
 * Description: A wonderfull plugin.
 * Author: Sven Wagener
 * Author URI: https://sven-wagener.com
 * Version: 1.2.3
 * Text Domain: myplugin
 * Domain Path: /assets/langauges/
 * Template Path: /templates
 * Network: true
 * Requires at least: 5.4.0
 * Requires PHP: 7.1.0
 */

namespace AWSM\LibWP\Examples\Plugin;

require '../../../vendor/autoload.php';

use AWSM\LibWP\WP\Exception;
use AWSM\LibWP\WP\Core\Plugin;
use AWSM\LibWP\WP\Core\AdminNotices;
use AWSM\LibWP\Examples\Plugin\Components\HelloWorld\HelloWorld;
use AWSM\LibWP\WP\ExceptionCatcher;

class MyPlugin extends Plugin {}

try {
    MyPlugin::init()
        ->addComponent( HelloWorld::class );
} catch ( Exception $e ) {
    ExceptionCatcher::error( sprintf( 'Failed to run Plugin: %s', $e->getMessage() ) );
}