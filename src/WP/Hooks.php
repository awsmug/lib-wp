<?php

namespace AWSM\SystemLayer\WP;

use Exception;
use ReflectionMethod;

/**
 * Class hooks
 * 
 * This class makes it possible to assign hooks outside of classes. By assigning
 * the hooks in a list outside of the class it is possible make hook lists in 
 * separated scripts for clearer overview.
 * 
 * Adding hooks:
 * 
 * Hooks::instance()
 *        ->add( new WPFilter( 'wp_title',  [ Settings::class, 'filterTitle' ]  ) )
 *        ->add( new WPAction( 'wp_head',   [ Scrits::class, 'headeScripts' ]  ) )
 *        ->add( new WPAction( 'wp_footer', [ Scrits::class, 'footerScripts' ]  ) );
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
class Hooks {
    /**
     * Instance
     * 
     * @var Hooks|null
     * 
     * @since 1.0.0
     */
    protected static $instance = null;

    /**
     * Assigned objects
     * 
     * @var array
     * 
     * @since 1.0.0
     */
    public $assignedObjects = [];

    /**
     * Current class
     * 
     * @var string
     * 
     * @since 1.0.0
     */
    public $currentClass;

    /**
     * Hooks
     * 
     * @var array
     * 
     * @since 1.0.0
     */
    protected $hooks = [];

    /**
     * Singleton
     * 
     * @return Hooks
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
     * Add Hook
     * 
     * @param HookInterface
     * 
     * @return Hooks
     * 
     * @since 1.0.0
     */
    public function add( HookInterface $hook ) {
        if ( ! is_array( $hook->callback() ) ) {
            throw new Exception( 'Adding hooks for functions is not allowed' );
        }

        $this->hooks[] = $hook;

        return $this;
    }

    /**
     * Assign Hooks
     * 
     * Needs to be executed in class which contains hooks to add.
     * 
     * @since 1.0.0
     */
    public static function assign( $object ) {
        self::instance()->assignedObjects[ get_class( $object ) ] = $object;
        self::instance()->currentClass = get_class( $object );
        self::instance()->addHooks();
    }

    /**
     * Running all hooks to assign
     * 
     * @since 1.0.0
     */
    private function addHooks() {
        foreach( $this->hooks AS $hook ) {
            $this->addHook( $hook );
        }
    }

    /**
     * Adding hook on assigning
     * 
     * @param HookInterface
     * 
     * @since 1.0.0
     */
    private function addHook( HookInterface $hook ) {
        $callback = $hook->callback();

        if ( $this->currentClass !== $callback[0] ) {
            return;
        }

        $reflectionMethod = new ReflectionMethod( $callback[0], $callback[1] );

        // If method is not static take object for hook callback.
        if ( ! $reflectionMethod->isStatic() ) {
            $object = $this->assignedObjects[ $callback['0'] ];
            $hook->callback( [ $object, $callback[1] ] );
        }

        call_user_func_array( 'add_' . $hook->type(), $hook->args() );
    }
}