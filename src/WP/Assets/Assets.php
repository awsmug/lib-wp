<?php

namespace AWSM\LibWP\WP\Assets;

use AWSM\LibWP\WP\Assets\Asset AS Asset;
use Exception;

/**
 * Class Assets
 * 
 * This class makes it possible to assign hooks outside of classes. By assigning
 * the hooks in a list outside of the class it is possible make hook lists in 
 * separated scripts for clearer overview.
 * 
 * Adding hooks:
 * 
 * Hooks::instance()
 *        ->add( new Filter( 'wp_title',  [ Settings::class, 'filterTitle' ]  ) )
 *        ->add( new Action( 'wp_head',   [ Scrits::class, 'headerScripts' ]  ) )
 *        ->add( new Action( 'wp_footer', [ Scrits::class, 'footerScripts' ]  ) );
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
class Assets {
    /**
     * Instance
     * 
     * @var Assets|null
     * 
     * @since 1.0.0
     */
    protected static $instance = null;

    /**
     * Assets
     * 
     * @var array
     * 
     * @since 1.0.0
     */
    protected $assets = [];

    /**
     * Singleton
     * 
     * @return Assets
     * 
     * @since 1.0.0
     */
    public static function instance() {
        if ( static::$instance === null ) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    /**
     * Add Asset
     * 
     * @param Asset
     * 
     * @return Hooks
     * 
     * @since 1.0.0
     */
    public function add( Asset $asset ) {
        $this->assets[] = $asset;

        return $this;
    }

    /**
     * Running all hooks to assign
     * 
     * @since 1.0.0
     */
    private function addAssets() {
        foreach( $this->assets AS $asset ) {
            $this->addAsset( $asset );
        }
    }

    /**
     * Adding hook on assigning
     * 
     * @param HookInterface
     * 
     * @since 1.0.0
     */
    private function addAsset( Asset $asset ) {
        call_user_func_array( 'wp_enqueue_' . $asset->getType(), $asset->getArgs() );
    }
}