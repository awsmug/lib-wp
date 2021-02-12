<?php

namespace AWSM\LibWP\WP\Core;

use AWSM\LibWP\Component\Component;
use AWSM\LibWP\WP\Assets\Assets;
use AWSM\LibWP\WP\Exception;
use AWSM\LibWP\WP\ExceptionCatcher;
use AWSM\LibWP\WP\ExceptionCatcherInterface;
use AWSM\LibWP\WP\Hooks\Action;
use AWSM\LibWP\WP\Hooks\HookableTrait;
use AWSM\LibWP\WP\Hooks\Hooks;

use ReflectionClass;

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
    protected $components;

    /**
     * Plugin information.
     * 
     * @var string|ExceptionCatcherInterface
     */
    protected $exceptionCatcher;

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
     * AdminNotices object.
     * 
     * @var AdminNotices Assets object;
     * 
     * @since 1.0.0
     */
    private $adminNotices;

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
     * Create an instance of plugin.
     * 
     * @return Plugin Plugin object.
     * 
     * @since 1.0.0
     */
    public static function instance() : Plugin 
    {
        if ( self::$instance === null ) {
            $calledClass = get_called_class();
            self::$instance = new $calledClass();

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
        $this->loadComponents();
    }

    /**
     * Setting up plugin.
     * 
     * @since 1.0.0
     */
    private function init() 
    {
        if( empty( $this->exceptionCatcher ) ) {
            $this->setExceptionCatcher( ExceptionCatcher::class );
        } else {
            $this->setExceptionCatcher( $this->exceptionCatcher );
        }

        $textDomain = $this->info()->getTextDomain();
        $domainPath = $this->info()->getDomainPath();

        $this->hooks        = new Hooks( $this );
        $this->assets       = new Assets( $this );
        $this->adminNotices = new AdminNotices( $this );

        if ( ! empty( $textDomain ) && ! empty( $domainPath ) ) {
            $this->loadTextdomain( $textDomain, $domainPath );
        }
    }

    /**
     * Load components.
     * 
     * @since 1.0.0
     */
    private function loadComponents() 
    {
        foreach( $this->components AS $index => $component ) {
            try {
                unset ( $this->components[ $index ] );
                $componentName = $component;
                $this->components[ $componentName ] = $this->loadComponent( $component );
            } catch ( Exception $e ) {
                $this->exceptionCatcher()->error( sprintf( 'Failed to run Plugin: %s', $e->getMessage() ) );
            }
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
    private function loadComponent( string $className ) : Component
    {
        if( ! class_exists( $className ) ) {
            throw new CoreException( sprintf( 'Class %s does not exist.', $className ) );
        }

        $reflector = new ReflectionClass( $className );

        if ( $reflector->getParentClass()->getName() !== Component::class ) {
            throw new CoreException( sprintf( 'Class "%s" must be child of "%s"', $className, Component::class ) );
        }

        return new $className( $this );
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
     * @param bool   $return       True returns the content, false directly loads the content. False is default.
     * 
     * @since 1.0.0
     */
    public function loadTemplate( string $templateFile, array $variables = [], bool $return = false ) 
    {
        $templateFileInTheme = get_called_class() . '/' . $templateFile;
        $templateLocation    = locate_template( $templateFileInTheme );

        if ( empty ( $templateLocation ) ) {
            $templateLocation = $this->info()->getPath() . $this->info()->getTemplatePath() . $templateFile;
        }

        if ( ! file_exists( $templateLocation ) ) {
            throw new Exception( sprintf( 'Could not load template "%s"', $templateLocation ) );
        }

        if ( $return ) {
            ob_start();
            require( $templateLocation );
            return ob_get_clean();    
        }

        require( $templateLocation );
    }

    /**
     * Setting exception catcher.
     * 
     * @param string $exceptionCatcher Exception catcher class.
     * 
     * @since 1.0.0
     */
    public function setExceptionCatcher( string $exceptionCatcherClass ) 
    {        
        $this->exceptionCatcher = new $exceptionCatcherClass( $this );
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
     * Admin notices.
     * 
     * @return AdminNotices AdminNotices object.
     * 
     * @since 1.0.0
     */
    public function adminNotices() : AdminNotices
    {
        return $this->adminNotices;
    }
}