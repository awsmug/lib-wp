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
    private $type;

    /**
     * File of asset
     * 
     * @var string
     * 
     * @since 1.0.0
     */
    private $file;

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
     * Set file
     * 
     * @param string $file Asset file.
     * 
     * @since 1.0.0
     */
    public function setFile( string $file ) {
        $this->file = $file;
    }

    /**
     * Get file to asset
     * 
     * @return string file to asset.
     * 
     * @since 1.0.0
     */
    public function getFile() : string 
    {
        return $this->file;
    }

    /**
     * Get type of asset
     * 
     * @return string File to asset.
     * 
     * @since 1.0.0
     */
    public function getType() : string 
    {
        if ( empty( $this->type ) ) {
            $this->detectType();
        }

        return $this->type;
    }


    /**
     * Detect component directory
     * 
     * @return string Component directory.
     * 
     * @since 1.0.0
     */
    private function detectType() : void
    {
        $extension = File::use( $this->file )->extension();

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