<?php

namespace AWSM\LibWP\Component;

use AWSM\LibFile\File;
use AWSM\LibTools\CallerDetective;

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
     * The entrypoint file path.
     * 
     * This path must contain the very first script which have to be loaded which requires all necessary scripts.
     * 
     * @var string
     * 
     * @since 1.0.0 
     */
    protected $entryPoint;

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
    public function __construct( string $entryPointFile = '', string $hooksFile = '', string $assetsFile = '' )
    {
        $this->dir  = $this->detectDir();
    
        $this->entryPoint = ! empty( $entryPointFile ) ? $this->dir . '/' . $entryPointFile : $this->dir . '/App/Main.php';
        $this->hooksFile  = ! empty( $hooksFile ) ? $this->dir . '/' . $hooksFile : $this->dir . '/App/Main.php';
        $this->assetsFile = ! empty( $assetsFile ) ? $this->dir . '/' . $assetsFile : $this->dir . '/App/Main.php';
    }

    /**
     * Get component directory
     * 
     * @return string Component directory.
     * 
     * @since 1.0.0
     */
    public function dir() {
        return $this->dir;
    }

    /**
     * Get component entryPoint
     * 
     * @return string Component entryPoint.
     * 
     * @since 1.0.0
     */
    public function entryPoint() {
        return $this->entryPoint;
    }

    /**
     * Get component hooks file
     * 
     * @return string Component hooks file.
     * 
     * @since 1.0.0
     */
    public function hooksFile() {
        return $this->hooksFile;
    }

    /**
     * Get component assets file
     * 
     * @return string Component assets file.
     * 
     * @since 1.0.0
     */
    public function assetsFile() {
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