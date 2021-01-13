<?php

namespace AWSM\LibWP\WP\Core;

use AWSM\LibWP\WP\Hooks\HookableHiddenMethodsTrait;
use AWSM\LibWP\WP\Core\CoreException;
use AWSM\LibWP\WP\Hooks\Action;
use AWSM\LibWP\WP\Hooks\Hooks;

/**
 * Abstract Plugin class.
 * 
 * @since 1.0.0
 */
abstract class Plugin 
{
    use HookableHiddenMethodsTrait;

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
    public static function init() : Plugin 
    {
        $calledClass = get_called_class();      
        return new $calledClass();
    }

    /**
     * Setting up plugin
     * 
     * @since 1.0.0
     */
    private function setup() {
        // Loading textdomain if exists in plugin header information
        if ( ! empty( self::info()->getTextDomain() ) && ! empty( self::info()->getDomainPath() ) ) {
            Hooks::instance()->add( new Action( 'init', [ $this, 'loadTextdomain' ] ) )->load( $this );
        }
    }

    /**
     * Plugin information
     * 
     * @return PluginInfo
     * 
     * @since 1.0.0
     */
    public static function info() : PluginInfo
    {
        $calledClass = get_called_class();
        $reflector   = new \ReflectionClass( $calledClass ); 

        return new PluginInfo( $reflector->getFileName() );
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
        if( ! class_exists( $className ) ) 
        {
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
    private function enqueueComponents() 
    {
        if ( $this->enqueuedComponents ) {
            return;
        }

        $this->enqueuedComponents = true;

        Hooks::instance()->add( new Action( 'plugins_loaded', [ $this, 'loadComponents' ] ) )->load( $this );
    }

    /**
     * Load components
     * 
     * @since 1.0.0
     */
    private function loadComponents() 
    {
        foreach( $this->components AS $component ) {
            $component = new $component();
            $component->init();
        }
    }

    /**
     * Load textdomain
     * 
     * @throws CoreException .mo file was not found.
     * 
     * @since 1.0.0
     */
    private function loadTextdomain() 
    {
        $textDomain    = self::info()->getTextDomain();
        $pluginRelPath = self::info()->getDomainPath();

        if( ! load_plugin_textdomain( $textDomain, false, $pluginRelPath ) ) {
            throw new CoreException( 'Textdomain file not found' );
        }
    }
}

