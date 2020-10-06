<?php

namespace AWSM\LibWP\WP\Assets;

use AWSM\LibTools\Patterns\SingletonTrait;
use AWSM\LibWP\WP\Assets\Asset AS Asset;
use AWSM\LibWP\WP\Hooks\HookableHiddenMethodsTrait;

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
     * Whether assets are already enqueues or not.
     * 
     * @var bool
     * 
     * @since 1.0.0
     */
    private $enqueuedAssets = false;

    /**
     * Assets
     * 
     * @var array
     * 
     * @since 1.0.0
     */
    protected $assets = [];

    /**
     * Constructor
     * 
     * @since 1.0.0
     */
    private function __construct() 
    {      
        $this->setHookableHiddenMethods( ['loadAssets', 'loadAdminStyles', 'loadAdminScripts', 'loadScripts', 'loadFooterScripts'] );
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
    public function add( Asset $asset, bool $check = true  ) 
    {
        if( ! $check ) {
            return;
        }

        $this->assets[ $asset->getLoaderHook() ][] = $asset;
        $this->enqueueAssets();

        return $this;
    }

    /**
     * Running all assets to be assigned
     * 
     * @since 1.0.0
     */
    private function enqueueAssets() 
    {
        if( $this->enqueuedAssets ) {
            return;
        }

        add_action( 'plugins_loaded', [ $this, 'loadAssets' ] );
    }

    /**
     * Add necessary hooks
     * 
     * @since 1.0.0 
     */
    private function loadAssets() 
    {
        $loaderHooks = [
            'admin_print_styles'    => 'loadAdminStyles',
            'admin_enqueue_scripts' => 'loadAdminScripts',
            'wp_enqueue_scripts'    => 'loadScripts',
            'wp_footer'             => 'loadFooterScripts'
        ];

        foreach( $loaderHooks AS $hookName => $callbackFunction ) 
        {
            if ( array_key_exists( $hookName, $this->assets ) ) 
            {
                add_action( $hookName, [ $this, $callbackFunction ] );
            }
        }
    }

    /**
     * Load admin style assets
     * 
     * @since 1.0.0
     */
    private function loadAdminStyles() 
    {
        $this->loadHookAssets( 'admin_print_styles' );
    }

    /**
     * Load admin script assets
     * 
     * @since 1.0.0
     */
    private function loadAdminScripts() 
    {
        $this->loadHookAssets( 'admin_enqueue_scripts' );
    }

    /**
     * Load script assets
     * 
     * @since 1.0.0
     */
    private function loadScripts() 
    {
        $this->loadHookAssets( 'wp_enqueue_scripts' );
    }

    /**
     * Load admin style
     * 
     * @since 1.0.0
     */
    private function loadFooterScripts() 
    {
        $this->loadHookAssets( 'wp_footer' );
    }
    
    /**
     * Loading assets for a specific hook
     * 
     * @param string $hookName Name of the hook.
     * 
     * @since 1.0.0
     */
    private function loadHookAssets( string $hookName ) {
        foreach( $this->assets[ $hookName ] AS $asset ) 
        {
            call_user_func_array( 'wp_enqueue_' . $asset->getType(), $asset->getArgs() );
        }
    }
}