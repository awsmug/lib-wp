<?php

namespace AWSM\LibWP\WP\Assets;

use AWSM\LibWP\Web\Assets\Asset as WebAsset;
use AWSM\LibWP\WP\Core\WP;

/**
 * Asset class for WordPress.
 * 
 * @since 1.0.0
 */
abstract class Asset Extends WebAsset implements AssetInterface 
{
    /**
     * Asset depencies
     * 
     * @var array
     * 
     * @since 1.0.0
     */
    private $depencies = [];

    /**
     * Set depencies
     * 
     * @param array Asset depencies.
     * 
     * @since 1.0.0
     */
    public function setDepencies( array $depencies ) 
    {
        $this->depencies = $depencies;
    }

    /**
     * Get depencies
     * 
     * @return array Asset depencies.
     * 
     * @since 1.0.0
     */
    public function getDepencies() 
    {
        return $this->depencies;
    }

    /**
     * Get asset url
     * 
     * @return string Asset url
     * 
     * @since 1.0.0
     */
    public function getUrl(): string
    {
        return WP::getUrl( $this->path );
    }

    /**
     * Get Handle.
     * 
     * @return string handle for WordPress
     * 
     * @since 1.0.0
     */
    protected function getHandle() 
    {
        return basename( $this->getFile() );
    }

    /**
     * Get args for enqueue funtion.
     * 
     * @return array
     * 
     * @since 1.0.0
     */
    abstract public function getArgs() : array;

    /**
     * Get loader hook.
     * 
     * @return array
     * 
     * @since 1.0.0
     */
    abstract public function getLoaderHook() : string;

}