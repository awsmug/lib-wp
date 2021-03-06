<?php

namespace AWSM\LibWP\WP;

use AWSM\LibWP\WP\Core\Plugin;

/**
 * Exception catcher.
 * 
 * This class helps to catch exceptions and routes it.
 * 
 * @since 1.0.0
 */
interface ExceptionCatcherInterface {
    /**
     * Constructor.
     * 
     * @param Plugin $plugin Plugin object.
     * 
     * @since 1.0.0
     */
    public function __construct( Plugin $plugin );

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