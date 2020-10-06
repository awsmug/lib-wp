<?php

namespace AWSM\LibWP\WP\Assets;

use AWSM\LibWP\WP\Core\Location;

/**
 * CSS asset class for WordPress.
 * 
 * @since 1.0.0
 */
final class JS Extends Asset implements AssetInterface {
    /**
     * Loading script in footer.
     * 
     * @var bool
     * 
     * @since 1.0.0
     */
    private $inFooter = true;

    public function __construct( string $file, array $depencies = [], bool $inFooter = true )
    {
        $this->setFile( $file );
        $this->setDepencies( $depencies );
        $this->inFooter = $inFooter;
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
            $this->inFooter
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
            return 'admin_enqueue_scripts';
        } else if ( Location::frontend() && $this->inFooter  ) {
            return 'wp_footer';
        } else if ( Location::frontend() ){
            return 'wp_enqueue_scripts';
        }
    }
}