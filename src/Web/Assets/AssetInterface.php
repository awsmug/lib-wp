<?php

namespace AWSM\LibWP\Web\Assets;

/**
 * Asset Interface.
 * 
 * @since 1.0.0
 */
interface AssetInterface {
    /**
     * Get asset url
     * 
     * Depending on system the url of the asset have to be returned.
     * 
     * @return string $url Asset url
     * 
     * @since 1.0.0
     */
    public function getUrl() :string;

    /**
     * Get path to asset
     * 
     * @return string Path to asset.
     * 
     * @since 1.0.0
     */
    public function getPath() : string;

    /**
     * Get type of asset
     * 
     * @return string Path to asset.
     * 
     * @since 1.0.0
     */
    public function getType() : string;
}