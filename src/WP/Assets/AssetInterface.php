<?php

namespace AWSM\LibWP\WP\Assets;

use AWSM\LibWP\Web\Assets\AssetInterface as WebAssetInterface;

/**
 * Class AssetInterface.
 * 
 * @since 1.0.0
 */
interface AssetInterface extends WebAssetInterface{
    /**
     * Type of asset
     * 
     * @return string Asset type (script/style).
     * 
     * @since 1.0.0 
     */
    public function getType() : string;

    /**
     * Arguments
     * 
     * @var array
     * 
     * @since 1.0.0
     */
    public function getArgs() : array;
}