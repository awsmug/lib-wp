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
        $message = $this->message( $message, 'Error' );

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
        $message = $this->message( $message, 'Warning' );

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
        $message = $this->message( $message, 'Notice' );

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
        $message = $this->message( $message, 'Info' );

        if( Location::admin() ) {
            $this->plugin()->adminNotices()->add( $message, 'info' );
        }
    }

    /**
     * Formatting message.
     * 
     * @param string $message Message to print.
     * 
     * @since 1.0.0
     */
    private function message( string $message, string $type ) : string {
        return  sprintf( '<b>%s</b> - %s: %s', 
            $this->plugin()->info()->getName(), 
            $type,
            $message
        );
    }
}