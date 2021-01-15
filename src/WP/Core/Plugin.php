<?php

namespace AWSM\LibWP\WP\Core;

use AWSM\LibWP\WP\Assets\Assets;
use AWSM\LibWP\WP\Exception;
use AWSM\LibWP\WP\ExceptionCatcher;
use AWSM\LibWP\WP\ExceptionCatcherInterface;
use AWSM\LibWP\WP\Hooks\Action;
use AWSM\LibWP\WP\Hooks\HookableTrait;
use AWSM\LibWP\WP\Hooks\Hooks;

/**
 * Abstract Plugin class.
 * 
 * @since 1.0.0
 */
abstract class Plugin 
{
    use HookableTrait;

    /**
     * Instance
     * 
     * @var self
     * 
     * @since 1.0.0
     */
    private static $instance;    

    /**
     * Components
     * 
     * @var array List of component class names.
     * 
     * @since 1.0.0
     */
    private $components;

    /**
     * Hooks object.
     * 
     * @var Hooks
     * 
     * @since 1.0.0
     */
    private $hooks;

    /**
     * Assets object.
     * 
     * @var Assets Assets object;
     * 
     * @since 1.0.0
     */
    private $assets;

    /**
     * Whether components are enqueued to actionhook or not
     * 
     * @var bool
     * 
     * @since 1.0.0  
     */
    private $enqueuedComponents = false;

    /**
     * Plugin information.
     * 
     * @var PluginInfo
     */
    private $info;

    /**
     * Plugin information.
     * 
     * @var ExceptionCatcherInterface
     */
    private $exceptionCatcher;

    /**
     * Create an instance of plugin.
     * 
     * @return Plugin Plugin object.
     * 
     * @since 1.0.0
     */
    public static function instance() : Plugin 
    {
        if ( self::$instance === null ) {
            self::$instance = new self();
        }
    
        return self::$instance;
    }

    /**
     * Constructor.
     * 
     * @since 1.0.0
     */
    private function __construct()
    {        
        $this->init();
    }

    /**
     * Plugin information
     * 
     * @return PluginInfo PluginInfo object.
     * 
     * @since 1.0.0
     */
    public function info() : PluginInfo
    {
        if ( empty( $this->info ) ) {
            $calledClass = get_called_class();
            $reflector   = new \ReflectionClass( $calledClass ); 

            $this->info = new PluginInfo( $reflector->getFileName() );
        }

        return $this->info;
    }

    /**
     * Setting up plugin
     * 
     * @since 1.0.0
     */
    private function init() 
    {
        $this->setHookableHiddenMethods( [ 'loadComponents' ] );
        $this->exceptionCatcher = new ExceptionCatcher();

        $textDomain = $this->info()->getTextDomain();
        $domainPath = $this->info()->getDomainPath();

        $this->hooks  = new Hooks();
        $this->assets = new Assets();

        if ( ! empty( $textDomain ) && ! empty( $domainPath ) ) {
            $this->loadTextdomain( $textDomain, $domainPath );
        }
    }

    /**
     * Get hooks object.
     * 
     * @return Hooks Hooks object.
     * 
     * @since 1.0.0
     */
    public function hooks() : Hooks
    {
        return $this->hooks;
    }

    /**
     * Get assets object.
     * 
     * @return Hooks Hooks object.
     * 
     * @since 1.0.0
     */
    public function assets() : Assets
    {
        return $this->assets;
    }

    /**
     * Load template.
     * 
     * @param string $templateFile Template file relative to the given template path. First lookup is made in theme directory, second in plugin dirctory template path.
     * @param array  $variables    Variable array to pass to template.
     * 
     * @since 1.0.0
     */
    public function loadTemplate( string $templateFile, array $variables ) {
        $templateFileInTheme = get_called_class() . '/' . $templateFile;
        $templateLocation    = locate_template( $templateFileInTheme );

        if ( empty ( $templateLocation ) ) {
            $templateLocation = $this->info()->getPath() . $this->info()->getTemplatePath() . $templateFile;
        }

        require( $templateLocation );
    }

    /**
     * Setting exception catcher.
     * 
     * @param ExceptionCatcherInterface $exceptionCatcher Exception catcher object.
     * 
     * @since 1.0.0
     */
    public function setExceptionCatcher( ExceptionCatcherInterface $exceptionCatcher ) 
    {
        $this->exceptionCatcher = $exceptionCatcher;
    }

    /**
     * Get exception catcher.
     * 
     * @return ExceptionCatcherInterface Exception catcher object.
     * 
     * @since 1.0.0
     */
    public function exceptionCatcher() : ExceptionCatcherInterface 
    {
        return $this->exceptionCatcher;
    }

    /**
     * Load textdomain.
     * 
     * @throws CoreException .mo file was not found.
     * 
     * @since 1.0.0
     */
    private function loadTextdomain( string $textDomain, string $domainPath )
    {
        if( ! load_plugin_textdomain( $textDomain, false, $domainPath ) ) {
            throw new Exception( sprintf( 'Textdomain %s file not found in %s.', $textDomain, $domainPath ) );
        }
    }

    /**
     * Add component.
     * 
     * The components will be added here and loaded at hook plugins_loaded on priority 1.
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
     * Enqueue components for loading.
     * 
     * @since 1.0.0 
     */
    private function enqueueComponents() 
    {
        if ( $this->enqueuedComponents ) {
            return;
        }

        $this->enqueuedComponents = true;        

        Hooks::instance()->add( new Action( 'plugins_loaded', [ $this, 'loadComponents' ], 1 ) )->load( $this );
    }

    /**
     * Load components. 
     * 
     * Will be executed in plugins_loaded on priority 1.
     * 
     * @since 1.0.0
     */
    private function loadComponents() 
    {
        foreach( $this->components AS $component ) {
            ( new $component( $this ) )->init();
        }
    }
}

