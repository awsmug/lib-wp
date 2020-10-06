<?php

namespace AWSM\LibWP\Component;

use AWSM\LibFile\File;
use AWSM\LibTools\Callbacks\CallerDetective;

/**
 * Component setup.
 * 
 * This class contains all setup information of a component.
 * 
 * @since 1.0.0
 */
class ComponentSetup {
    /**
     * The component directory.
     * 
     * @var string
     * 
     * @since 1.0.0 
     */
    protected $dir;

    /**
     * The hooks file path.
     * 
     * This path must contain the hooks file which contains the necessary hooks list.
     * 
     * @var string
     * 
     * @since 1.0.0 
     */
    protected $hooksFile;

    /**
     * The assets file path.
     * 
     * This path must contain the assets file which contains the necessary assets list.
     * 
     * @var string
     * 
     * @since 1.0.0 
     */
    protected $assetsFile;

    /**
     * Constructor
     * 
     * @var string $entryPointFile The entrypoint file relative to the component file.
     * @var string $hooksFile      The hooks file path relative to the component file.
     * @var string $assetsFile     The assets file path relative to the component file.
     * 
     * @since 1.0.0
     */
    public function __construct( string $hooksFile = '', string $assetsFile = '' )
    {
        if( ! empty( $hooksFile ) ) 
        {
            $this->hooksFile = $this->getDir() . '/' . $hooksFile;
        } else {
            $this->hooksFile = $this->getDir() . '/Hooks.php';
        }

        if( ! empty( $assetsFile ) ) 
        {
            $this->assetsFile = $this->getDir() . '/' . $assetsFile;
        } else {
            $this->assetsFile = $this->getDir() . '/Assets.php';
        }
    }

    /**
     * Get component directory
     * 
     * @return string Component directory.
     * 
     * @since 1.0.0
     */
    public function getDir() 
    {
        if( ! empty( $this->dir ) ) 
        {
            return $this->dir;
        }

        $this->dir = $this->detectDir();

        return $this->dir;
    }

    /**
     * Get component hooks file
     * 
     * @return string Component hooks file.
     * 
     * @since 1.0.0
     */
    public function getHooksFile() 
    {
        return $this->hooksFile;
    }

    /**
     * Get component assets file
     * 
     * @return string Component assets file.
     * 
     * @since 1.0.0
     */
    public function getAssetsFile() 
    {
        return $this->assetsFile;
    }

    /**
     * Detect component directory
     * 
     * @return string Component directory
     * 
     * @since 1.0.0
     */
    private function detectDir() 
    {
        $file = CallerDetective::detect( 2 )->file();
        return File::use( $file )->dir();
    }
}