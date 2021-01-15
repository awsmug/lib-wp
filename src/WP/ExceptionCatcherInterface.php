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
interface ExceptionCatcherInterface {
    /**
     * Catching error.
     * 
     * @param string $message Message to show.
     * 
     * @since 1.0.0
     */
    public static function error( string $message );

    /**
     * Catching warning.
     * 
     * @param string $message Message to show.
     * 
     * @since 1.0.0
     */
    public static function warning( string $message );

    /**
     * Catching notice.
     * 
     * @param string $message Message to show.
     * 
     * @since 1.0.0
     */
    public static function notice( string $message ):

    /**
     * Catching info.
     * 
     * @param string $message Message to show.
     * 
     * @since 1.0.0
     */
    public static function info( string $message );

    /**
     * Get exception location.
     * 
     * @return string Description of location where exception happened.
     * 
     * @since 1.0.0
     */
    private static function exceptionLocation();
}