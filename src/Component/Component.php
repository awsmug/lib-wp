<?php

namespace AWSM\LibWP\Component;

use AWSM\LibFile\PhpFile;
use AWSM\LibWP\WP\Core\Plugin;
use AWSM\LibWP\WP\Hooks\Hooks;

/**
 * Component class.
 * 
 * This class initiates and runs the components.
 * 
 * @since 1.0.0
 */
abstract class Component implements ComponentInterface 
{
    /**
     * Plugin object.
     * 
     * @var Plugin
     */
    private $plugin;

    /**
     * Component setup.
     * 
     * @var ComponentSetup
     * 
     * @since 1.0.0
     */
    private $setup;

    /**
     * Constructor.
     * 
     * @param Plugin $plugin Plugin object.
     * 
     * @since 1.0.0
     */
    public function __construct( Plugin $plugin )
    {
        $this->plugin = $plugin;
    }

    /**
     * Plugin access.
     * 
     * @return Plugin Plugin object.
     * 
     * @since 1.0.0
     */
    public function plugin() {
        return $this->plugin;
    }

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
    protected function setup( string $hooksFile = '', string $assetsFile = '' ) 
    {
        $this->setup = new ComponentSetup( $this->getDir(), $hooksFile, $assetsFile );
    }

    /**
     * Get directory of component
     * 
     * @return string Directory of called class.
     * 
     * @since 1.0.0
     */
    private function getDir() : string 
    {
        $calledClass = get_called_class();
        $reflector   = new \ReflectionClass($calledClass); 
        return dirname( $reflector->getFileName() );
    }

    /**
     * Starting the component.
     * 
     * @since 1.0.0
     */
    public function init() 
    {
        if ( empty ( $this->setup ) ) {
            $this->setup();
        }
        
        PhpFile::use( $this->setup->getHooksFile() )->run();
        PhpFile::use( $this->setup->getAssetsFile() )->run();

        Hooks::instance()->load( $this );
    }
}