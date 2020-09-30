<?php

namespace AWSM\LibWP\WP\Core;

use AWSM\LibTools\Callbacks\CallerDetective;
use AWSM\LibWP\WP\Hooks\HookableHiddenMethodsTrait;
use CoreException;

/**
 * Abstract Plugin class.
 * 
 * @since 1.0.0
 */
class Plugin {
    use HookableHiddenMethodsTrait;

    /**
     * Plugin informations from plugin header.
     * 
     * @var PluginInfo
     * 
     * @since 1.0.0
     */
    private $info;

    /**
     * Components
     * 
     * @var array List of component class names.
     * 
     * @since 1.0.0
     */
    private $components;

    /**
     * Whether components are enqueued to actionhook or not
     * 
     * @var bool
     * 
     * @since 1.0.0  
     */
    private $enqueuedComponents = false;

    /**
     * Constructor
     * 
     * @since 1.0.0
     */
    private function __construct()
    {
        $this->setHookableHiddenMethods( [ 'loadTextdomain', 'loadComponents' ] );
        $this->setup();
    }

    /**
     * Intitialize the Plugin
     * 
     * @return Plugin
     * 
     * @since 1.0.0
     */
    public static function init() : Plugin {      
        return new self;
    }

    /**
     * Setting up plugin
     * 
     * @since 1.0.0
     */
    public function setup() {
        // Loading textdomain if exists in plugin header information
        if ( ! empty( $this->info()->getTextDomain() ) && ! empty( $this->info()->getDomainPath() ) ) {
            add_action( 'init', [ $this, 'loadTextdomain'] );
        }
    }

    /**
     * Plugin information
     * 
     * @return PluginInfo
     * 
     * @since 1.0.0
     */
    private function info() : PluginInfo
    {
        if ( ! empty( $this->info ) ){
            return $this->info;
        }

        $file       = CallerDetective::detect(2)->file();
        $this->info = new PluginInfo( $file );

        return $this->info;
    }

    /**
     * Add component
     * 
     * @throws CoreException Class does not exist. 
     * 
     * @since 1.0.0
     */
    public function addComponent( string $className ) : Plugin
    {
        if( ! class_exists( $className ) ) {
            throw new CoreException( sprintf( 'Class %s does not exist.', $className ) );
        }

        $this->components[] = $className;
        $this->enqueueComponents();

        return $this;
    }

    /**
     * Enqueue components for loading
     * 
     * @since 1.0.0 
     */
    private function enqueueComponents() {
        if ( $this->enqueuedComponents ) {
            return;
        }

        $this->enqueuedComponents = true;

        add_action( 'plugins_loaded', [ $this, 'loadComponents'] );
    }

    /**
     * Load components
     * 
     * @since 1.0.0
     */
    private function loadComponents() {
        foreach( $this->components AS $component ) {
            $component = new $component();
            $component->start();
        }
    }

    /**
     * Load textdomain
     * 
     * @throws CoreException .mo file was not found.
     * 
     * @since 1.0.0
     */
    private function loadTextdomain() {
        $textDomain        = $this->info()->getTextDomain();
        $pluginRelPath = $this->info()->getDomainPath();

        if( ! load_plugin_textdomain( $textDomain, false, $pluginRelPath ) ) {
            throw new CoreException( 'Textdomain file not found' );
        }
    }
}

