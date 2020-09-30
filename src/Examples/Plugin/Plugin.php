<?php

/**
 * Plugin Name: My Plugin
 * Description: A wonderfull plugin.
 * Author: Sven Wagener
 * Author URI: https://sven-wagener.com
 * Version: 1.2.3
 * Text Domain: myplgin
 * Domain Path: /assets/langauges/
 * Network: true
 * Requires at least: 5.4.0
 * Requires PHP: 7.1.0
 */

namespace AWSM\LibWP\Examples\Plugin;

require '../../../vendor/autoload.php';

use AWSM\LibWP\WP\Core\Plugin;
use AWSM\LibWP\WP\Core\WP;
use AWSM\LibWP\Examples\Plugin\Components\HelloWorld\App\Main;
use AWSM\LibWP\WP\WPException;

try {
    Plugin::init()
        ->addComponent( Main::class );
} catch ( WPException $e ) {
    WP::alert( sprintf( 'Failed to run Plugin: %s', $e->getMessage() ) );
}