<?php

/**
 * Plugin Name: My Plugin
 * Description: A wonderfull plugin.
 * Author: Sven Wagener
 * Author URI: https://sven-wagener.com
 * Version: 1.2.3
 * Text Domain: myplugin
 * Domain Path: /assets/langauges/
 * Network: true
 * Requires at least: 5.4.0
 * Requires PHP: 7.1.0
 */

namespace AWSM\LibWP\Examples\Plugin;

require '../../../vendor/autoload.php';

use AWSM\LibWP\WP\WPException;
use AWSM\LibWP\WP\Core\Plugin;
use AWSM\LibWP\WP\Core\AdminNotices;
use AWSM\LibWP\Examples\Plugin\Components\HelloWorld\HelloWorld;

try {
    Plugin::init()->addComponent( HelloWorld::class );
} catch ( WPException $e ) {
    AdminNotices::instance()->add( sprintf( 'Failed to run Plugin: %s', $e->getMessage() ) );
}