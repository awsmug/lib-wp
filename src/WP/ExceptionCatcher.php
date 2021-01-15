<?php

namespace AWSM\LibWP\WP;

use AWSM\LibTools\Callbacks\CallerDetective;
use AWSM\LibWP\WP\Core\Location;
use AWSM\LibWP\WP\Core\Plugin;
use AWSM\LibWP\WP\Core\PluginTrait;

/**
 * Exception catcher.
 * 
 * This class helps to catch exceptions and routes it.
 * 
 * @since 1.0.0
 */
class ExceptionCatcher implements ExceptionCatcherInterface {
    use PluginTrait;

    /**
     * Constructor.
     * 
     * @param Plugin $plugin Plugin object.
     * 
     * @since 1.0.0
     */
    public function __construct( Plugin $plugin ) {
        $this->plugin = $plugin;
    }

    /**
     * Catching error.
     * 
     * @param string $message Message to show.
     * 
     * @since 1.0.0
     */
    public function error( string $message ) {
        $message = sprintf( 'Error: %s (%s)', $message, self::exceptionLocation() );

        if( Location::admin() ) {
            $this->plugin()->adminNotices()->add( $message, 'error' );
        }
    }

    /**
     * Catching warning.
     * 
     * @param string $message Message to show.
     * 
     * @since 1.0.0
     */
    public function warning( string $message ) {
        $message = sprintf( 'Warning: %s (%s)', $message, self::exceptionLocation() );

        if( Location::admin() ) {
            $this->plugin()->adminNotices()->add( $message, 'warning' );
        }
    }

    /**
     * Catching notice.
     * 
     * @param string $message Message to show.
     * 
     * @since 1.0.0
     */
    public function notice( string $message ) {
        $message = sprintf( 'Notice: %s (%s)', $message, self::exceptionLocation() );

        if( Location::admin() ) {
            $this->plugin()->adminNotices()->add( $message, 'notice' );
        }
    }

    /**
     * Catching info.
     * 
     * @param string $message Message to show.
     * 
     * @since 1.0.0
     */
    public function info( string $message ) {
        $message = sprintf( 'Info: %s (%s)', $message, self::exceptionLocation() );

        if( Location::admin() ) {
            $this->plugin()->adminNotices()->add( $message, 'info' );
        }
    }

    /**
     * Get exception location.
     * 
     * @return string Description of location where exception happened.
     * 
     * @since 1.0.0
     */
    private function exceptionLocation() {
        return sprintf ( 'in file "%s"',
            CallerDetective::detect(1)->file()
        );
    }
}