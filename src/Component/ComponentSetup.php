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
    public $directory;

    /**
     * The entrypoint file path.
     * 
     * This path must contain the very first script which have to be loaded which requires all necessary scripts.
     * 
     * @var string
     * 
     * @since 1.0.0 
     */
    public $entryPoint;

    /**
     * The hooks file path.
     * 
     * This path must contain the hooks file which contains the necessary hooks list.
     * 
     * @var string
     * 
     * @since 1.0.0 
     */
    public $hooks;

    /**
     * The assets file path.
     * 
     * This path must contain the assets file which contains the necessary assets list.
     * 
     * @var string
     * 
     * @since 1.0.0 
     */
    public $assets;

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
        $this->hooks      = ! empty( $hooksFile ) ? $this->dir . '/' . $hooksFile : $this->dir . '/App/Main.php';
        $this->assets     = ! empty( $assetsFile ) ? $this->dir . '/' . $assetsFile : $this->dir . '/App/Main.php';
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

    /**
     * Magic setter
     * 
     * @param string $variable Variable name.
     * @param mixed  $value    Value to set.
     * 
     * @since 1.0.0
     */
    public function __set( $variable, $value ) {
        switch( $variable ) {
            case 'entryPoint':
            case 'hooks':
            case 'assets':
                $this->$variable = $this->dir . '/' . $value;
                break;
            default:
                $this->$variable = $value;
                break;
        }
    }
}