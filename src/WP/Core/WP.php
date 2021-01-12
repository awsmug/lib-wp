<?php

namespace AWSM\LibWP\WP\Core;

use Exception;

/**
 * WP Class
 * 
 * This class helps out with some basic information about WordPress.
 * 
 * @since 1.0.0
 */
class WP {
    /**
     * Get WordPress installation directory.
     * 
     * @return string WordPress installation directory.
     * 
     * @since 1.0.0
     */
    public static function dir() : string 
    {
        if ( ! defined( 'ABSPATH' ) ) {
            return '';
        }

        return ABSPATH;
    }

    /**
     * Get path diff relative to working directory.
     * 
     * @return string Path diff
     * 
     * @since 1.0,0
     */
    public static function getPathDiff( string $absolutePath ) : string
    {
        $start  = strlen( self::dir() );
        $end    = strlen( $absolutePath );
        $length = $end - $start;

        $pathStart = substr( $absolutePath, 0, $start );

        if ( self::dir() !== $pathStart ) {
            throw new Exception('Path must be within ABSPATH of WordPress' );
        }

        return substr( $absolutePath, $start, $length );
    }

    /**
     * Get url of an absolut path.
     * 
     * @return string URl of path
     * 
     * @since 1.0.0
     */
    public static function getUrl( string $absolutePath ) 
    {
        return get_home_url() . '/' . self::getPathDiff( $absolutePath );
    }
}