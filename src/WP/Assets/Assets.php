<?php

namespace AWSM\LibWP\WP\Assets;

use AWSM\LibTools\Traits\SingletonTrait;
use AWSM\LibWP\WP\Assets\Asset AS Asset;
use AWSM\LibWP\WP\Hooks\Action;
use AWSM\LibWP\WP\Hooks\HookableHiddenMethodsTrait;
use AWSM\LibWP\WP\Hooks\Hooks;

/**
 * Class Assets
 * 
 * This class makes it possible to assign scripts and styles outside of classes.
 * 
 * Adding hooks:
 * 
 * Hooks::instance()
 *        ->add( new JS( 'Assets/Dist/JS/index.js' ) ]  ) )
 *        ->add( new CSS( 'Assets/Dist/CSS/styles.css'  ) );
 * 
 * To load the scripts it is necessary to assign the hooks to a class.
 * 
 * class Settings {
 *   public function __construct() {
 *     Hooks::assign( $this );
 *   }
 * 
 *   public function filterTitle() {
 *     return 'Das ist mein Seitentitel';
 *   }
 * }
 * 
 * 
 * @since 1.0.0
 */
class Assets 
{
    use HookableHiddenMethodsTrait, SingletonTrait;

    /**
     * Assets
     * 
     * @var array
     * 
     * @since 1.0.0
     */
    protected $assets = [];

    private function __construct() {
        Hooks::instance()->add( new Action( 'plugins_loaded', array( Assets::class, 'loadAssets' ) ) ); // We load it here, to let the core core clean.
        Hooks::assign( $this );
        
        $this->setHookableHiddenMethods( ['loadAssets'] );
    }

    /**
     * Add Asset
     * 
     * @param Asset $asset
     * @param bool  $check
     * 
     * @return Assets
     * 
     * @since 1.0.0
     */
    public function add( Asset $asset, bool $check = true  ) {
        if( ! $check ) {
            return;
        }

        $this->assets[] = $asset;

        return $this;
    }

    /**
     * Running all assets to be assigned
     * 
     * @since 1.0.0
     */
    private function loadAssets() {
        foreach( $this->assets AS $asset ) {
            $this->loadAsset( $asset );
        }
    }

    /**
     * Adding asset
     * 
     * @param HookInterface
     * 
     * @since 1.0.0
     */
    private function loadAsset( Asset $asset ) {
//         call_user_func_array( 'wp_enqueue_' . $asset->getType(), $asset->getArgs() );
    }
}