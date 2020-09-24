<?php

namespace AWSM\LibWP\Component;

use AWSM\LibFile\PhpFile;

/**
 * Component class.
 * 
 * This class initiates and runs the components.
 * 
 * @since 1.0.0
 */
class Component implements ComponentInterface {
    /**
     * Component setup.
     * 
     * @var ComponentSetup
     * 
     * @since 1.0.0
     */
    private $setup;

    /**
     * Setup the component.
     * 
     * @param string $entryPointFile File there the component starts. Default is 'App/Main.php' in the component directory.
     * @param string $hooksFile      File with hooks to load. Default is 'Hooks.php' in the component directory.
     * @param string $assetsFile     File with assets to load. Default is 'Apps.php' in the component directory.
     * 
     * @return ComponentSetup
     * 
     * @since 1.0.0
     */
    public function setup( string $entryPointFile = '', string $hooksFile = '', string $assetsFile = '' ) {
        if ( empty( $this->setup ) ) {
            $this->setup = new ComponentSetup( $entryPointFile, $hooksFile, $assetsFile );
        } else {
            $this->setup->entryPoint = ! empty( $entryPointFile ) ? $entryPointFile : $this->setup->entryPoint;
            $this->setup->hooksFile  = ! empty( $hooksFile ) ? $entryPointFile : $this->setup->hooksFile;
            $this->setup->assetsFile = ! empty( $assetsFile ) ? $entryPointFile : $this->setup->assetsFile;
        }
        
        return $this->setup;
    }

    /**
     * Starting the component.
     * 
     * @since 1.0.0
     */
    public function run() {
        PhpFile::use( $this->setup->hooks )->run();
        PhpFile::use( $this->setup->assets )->run();
        PhpFile::use( $this->setup->entryPoint )->run();
    }
}