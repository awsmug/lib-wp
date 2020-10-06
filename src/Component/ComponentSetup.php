<?php

namespace AWSM\LibWP\Component;

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
    public function __construct( string $dir, string $hooksFile = '', string $assetsFile = '' )
    {
        if( ! is_dir( $dir ) ) {
            throw new ComponentException( sprintf( 'Directory "%s" is not a directory', $dir ) );
        }

        $this->dir = $dir;
        
        if( ! empty( $hooksFile ) ) 
        {
            $this->hooksFile = $this->dir . '/' . $hooksFile;
        } else {
            $this->hooksFile = $this->dir . '/Hooks.php';
        }

        if( ! file_exists( $this->hooksFile ) ) {
            throw new ComponentException( sprintf( 'Hook file "%s" does not exist', $this->hooksFile ) );
        }

        if( ! empty( $assetsFile ) ) 
        {
            $this->assetsFile = $this->dir . '/' . $assetsFile;
        } else {
            $this->assetsFile = $this->dir . '/Assets.php';
        }

        if( ! file_exists( $this->assetsFile ) ) {
            throw new ComponentException( sprintf( 'Assets file "%s" does not exist', $this->assetsFile ) );
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
}