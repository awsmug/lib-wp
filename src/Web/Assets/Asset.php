<?php

namespace AWSM\LibWP\Web\Assets;

use AWSM\LibFile\File;
use Exception;

/**
 * Class Asset.
 * 
 * @since 1.0.0
 */
abstract class Asset implements AssetInterface {
    /**
     * Type of asset (script/style)
     * 
     * @var string
     * 
     * @since 1.0.0
     */
    protected $type;

    /**
     * Path of asset
     * 
     * @var string
     * 
     * @since 1.0.0
     */
    protected $path;

    /**
     * Constructor
     * 
     * @param string $path Path to asset.
     * 
     * @since 1.0.0
     */
    public function __construct( string $path )
    {
        $this->path = $path;

        $this->detectType();
    }

    /**
     * Get asset url
     * 
     * Depending on system the url of the asset have to be returned.
     * 
     * @return string $url Asset url
     * 
     * @since 1.0.0
     */
    abstract public function getUrl() :string;

    /**
     * Get path to asset
     * 
     * @return string Path to asset.
     * 
     * @since 1.0.0
     */
    public function getPath() : string 
    {
        return $this->path;
    }

    /**
     * Get type of asset
     * 
     * @return string Path to asset.
     * 
     * @since 1.0.0
     */
    public function getType() : string 
    {
        return $this->type;
    }


    /**
     * Detect component directory
     * 
     * @return string Component directory
     * 
     * @since 1.0.0
     */
    private function detectType() : void
    {
        $extension = File::use( $this->src )->extension();

        switch( $extension ) {
            case 'css':
                $this->type = 'style';
                break;
            case 'js':
                $this->type = 'script';
                break;
            default:
                throw new Exception( sprintf( 'Asset extension must be .css or .js, "%s" given.',$extension ) );
                break;
        }
    }
}