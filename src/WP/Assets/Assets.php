<?php

namespace AWSM\LibWP\WP\Assets;

use AWSM\LibWP\WP\Assets\Asset AS Asset;
use AWSM\LibWP\WP\Core\Plugin;
use AWSM\LibWP\WP\Core\PluginTrait;
use AWSM\LibWP\WP\Exception;
use AWSM\LibWP\WP\Hooks\Action;
use AWSM\LibWP\WP\Hooks\HookableTrait;

/**
 * Class Assets
 * 
 * This class makes it possible to assign scripts and styles outside of classes.
 * 
 * Adding assets:
 * 
 * MyPlugin::instance()->assets()
 *        ->add( new JS( 'Assets/Dist/JS/index.js' ) ]  ) )
 *        ->add( new CSS( 'Assets/Dist/CSS/styles.css'  ) );
 * 
 * To load the scripts it is necessary to assign the hooks to a class.
 * 
 * @since 1.0.0
 */
class Assets 
{
    use HookableTrait, PluginTrait;

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
    public function __construct( Plugin $plugin ) 
    {      
        $this->setHookableHiddenMethods( ['loadAssets', 'loadAdminStyles', 'loadAdminScripts', 'loadScripts', 'loadFooterScripts'] );
        $this->plugin = $plugin;
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

        $this->plugin()->hooks()->add( new Action( 'plugins_loaded', [ $this, 'loadAssets'] ) );
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
                $this->plugin()->hooks()->add( new Action( $hookName, [ $this, $callbackFunction ] ) );
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
        $callback = $callbackArgs[0];

        $args = array();
        if ( isset( $callbackArgs[1] ) ) {
            $args  = $callbackArgs[1];
        }

        if ( ! is_callable( $callback ) ) {
            throw new Exception( 'Callback is not callable %s.', printf( $callback, true ) );
        }

        if ( ! empty( $args ) ) {
            $value = call_user_func_array( $callback, $args );    
        } else {
            $value = call_user_func( $callback );
        }        

        if ( $value === true ) {
            return true;
        }

        return false;
    }
}