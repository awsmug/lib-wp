<?php

namespace AWSM\LibWP\WP\Assets;

use AWSM\LibWP\Web\Assets\Asset as WebAsset;
use AWSM\LibWP\WP\Core\WP;

/**
 * Asset class for WordPress.
 * 
 * @since 1.0.0
 */
class Asset Extends WebAsset implements AssetInterface {
    
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

    public function getArgs() : array{
    } 
}