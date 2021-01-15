<?php

namespace AWSM\LibWP\WP\Assets;

use AWSM\LibWP\WP\Assets\Asset AS Asset;
use AWSM\LibWP\WP\Core\Plugin;
use AWSM\LibWP\WP\Hooks\Action;
use AWSM\LibWP\WP\Hooks\HookableTrait;
use AWSM\LibWP\WP\Hooks\Hooks;
use Exception;

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
    use HookableTrait;

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
    protected function __construct() 
    {      
        $this->setHookableHiddenMethods( ['loadAssets', 'loadAdminStyles', 'loadAdminScripts', 'loadScripts', 'loadFooterScripts'] );
    }

    /**
     * Add Asset.
     * 
     * @param Asset $asset 
     * @param array $callbackArgs
     * 
     * @return Assets
     * 
     * @since 1.0.0
     */
    public function add( Asset $asset, array $callbackArgs = []  ) 
    {
        $this->assets[ $asset->getLoaderHook() ][] = [ 'asset' => $asset, 'callbackArgs' => $callbackArgs ];
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

        $this->enqueuedAssets = true;

        Hooks::instance()->add( new Action( 'plugins_loaded', [ $this, 'loadAssets'] ) )->load( $this );
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
                Hooks::instance()->add( new Action( $hookName, [ $this, $callbackFunction ] ) )->load( $this );
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
            if( ! $this->isEnqueueAllowed( $asset['callbackArgs'] ) ) {
                continue;
            }

            call_user_func_array( 'wp_enqueue_' . $asset['asset']->getType(), $asset['asset']->getArgs() );
        }
    }
    /**
     * Check is enqueuing is allowed by given callback check.
     * 
     * @param array $callbackArgs Array with callback and arguments e.g. [ $callback, $arguments ].
     * 
     * @return bool True if check is passed, false if not.
     * 
     * @since 1.0.0
     */
    private function isEnqueueAllowed( array $callbackArgs ) : bool 
    {
        $callback = array_slice( $callbackArgs, 0,1 );
        $args = array_slice( $callbackArgs, 1 );

        if( is_callable( $callback ) && ! call_user_func_array( $callback, $args ) ) {
            return false;
        }

        return true;
    }
}