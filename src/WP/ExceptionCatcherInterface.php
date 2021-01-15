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
    public function error( string $message );

    /**
     * Catching warning.
     * 
     * @param string $message Message to show.
     * 
     * @since 1.0.0
     */
    public function warning( string $message );

    /**
     * Catching notice.
     * 
     * @param string $message Message to show.
     * 
     * @since 1.0.0
     */
    public function notice( string $message );

    /**
     * Catching info.
     * 
     * @param string $message Message to show.
     * 
     * @since 1.0.0
     */
    public function info( string $message );
}