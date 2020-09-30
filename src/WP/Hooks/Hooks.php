<?php

namespace AWSM\LibWP\WP\Hooks;

use Exception;
use ReflectionMethod;

use AWSM\LibTools\Traits\SingletonTrait;

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
class Hooks 
{
    use SingletonTrait;
    
    /**
     * Assigned objects
     * 
     * @var string
     * 
     * @since 1.0.0
     */
    public $assignedObject;

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
     * Add Hook
     * 
     * @param HookInterface $hook
     * @param bool          $check
     * 
     * @return Hooks
     * 
     * @since 1.0.0
     */
    public function add( HookInterface $hook, bool $check = true ) {
        if( ! $check ) {
            return;
        }
        
        if ( ! is_array( $hook->getCallback() ) ) {
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
        self::instance()->assignedObject = $object;
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
        $callback = $hook->getCallback();

        if ( get_class( $this->assignedObject ) !== $callback[0] ) {
            return;
        }

        $reflectionMethod = new ReflectionMethod( $callback[0], $callback[1] );

        // If method is not static take object for hook callback.
        if ( ! $reflectionMethod->isStatic() ) {
            $hook->getCallback( [ $$this->assignedObject, $callback[1] ] );
        }

        call_user_func_array( 'add_' . $hook->getType(), $hook->getArgs() );
    }
}