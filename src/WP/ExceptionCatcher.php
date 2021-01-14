<?php

namespace AWSM\LibWP\WP;

use AWSM\LibTools\Callbacks\CallerDetective;
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
        $message = sprintf( 'Error: %s (%s)', $message, self::exceptionLocation() );

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
        $message = sprintf( 'Warning: %s (%s)', $message, self::exceptionLocation() );

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
        $message = sprintf( 'Notice: %s (%s)', $message, self::exceptionLocation() );

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
        $message = sprintf( 'Info: %s (%s)', $message, self::exceptionLocation() );

        if( Location::admin() ) {
            AdminNotices::instance()->add( $message, 'info' );
        }
    }

    /**
     * Get exception location.
     * 
     * @return string Description of location where exception happened.
     * 
     * @since 1.0.0
     */
    private static function exceptionLocation() {
        return sprintf ( 'in class "%s->%s of file "%s"',
            CallerDetective::detect(2)->className(),
            CallerDetective::detect(2)->functionName(),
            CallerDetective::detect(2)->file()
        );
    }
}