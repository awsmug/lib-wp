<?php

namespace AWSM\LibWP\WP;

use AWSM\LibWP\WP\Core\AdminNotices;
use AWSM\LibWP\WP\Core\Location;

/**
 * Exception catcher.
 * 
 * This class helps to catch exceptions and routes it.
 * 
 * @since 1.0.0
 */
class ExceptionCatcher {
    /**
     * Catching error.
     * 
     * @param string $message Message to show.
     * 
     * @since 1.0.0
     */
    public static function error( string $message ) {
        if( Location::admin() ) {
            AdminNotices::instance()->add( $message, 'error' );
        }
    }

    /**
     * Catching warning.
     * 
     * @param string $message Message to show.
     * 
     * @since 1.0.0
     */
    public static function warning( string $message ) {
        if( Location::admin() ) {
            AdminNotices::instance()->add( $message, 'warning' );
        }
    }

    /**
     * Catching notice.
     * 
     * @param string $message Message to show.
     * 
     * @since 1.0.0
     */
    public static function notice( string $message ) {
        if( Location::admin() ) {
            AdminNotices::instance()->add( $message, 'notice' );
        }
    }

    /**
     * Catching info.
     * 
     * @param string $message Message to show.
     * 
     * @since 1.0.0
     */
    public static function info( string $message ) {
        if( Location::admin() ) {
            AdminNotices::instance()->add( $message, 'info' );
        }
    }
}