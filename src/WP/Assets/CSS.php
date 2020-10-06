<?php

namespace AWSM\LibWP\WP\Assets;

use AWSM\LibWP\WP\Core\Location;

/**
 * CSS asset class for WordPress.
 * 
 * @since 1.0.0
 */
final class CSS Extends Asset implements AssetInterface {
    /**
     * The media for which this stylesheet has been defined.
     * 
     * @var bool
     * 
     * @since 1.0.0
     */
    private $media;

    public function __construct( string $file, array $depencies = [], string $media = '' )
    {
        $this->setFile( $file );
        $this->setDepencies( $depencies );
        $this->media = $media;
    }

    /**
     * Get args for enqueue funtion.
     * 
     * @return array Functions for wp_enqueue_script.
     * 
     * @since 1.0.0
     */
    public function getArgs() : array
    {
        return [
            $this->getHandle(),
            $this->getUrl(),
            $this->getDepencies(),
            fileatime( $this->getFile() ),
            $this->media
        ];
    }

    /**
     * Get load hook.
     * 
     * @return string Hook name.
     * 
     * @since 1.0.0
     */
    public function getLoaderHook() : string {
        if ( Location::admin() ) {
            return 'admin_print_styles';
        } else {
            return 'wp_enqueue_scripts';
        }
    }
}