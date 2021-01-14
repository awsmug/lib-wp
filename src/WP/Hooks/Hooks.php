<?php

namespace AWSM\LibWP\WP\Hooks;

use AWSM\LibTools\Patterns\SingletonTrait;

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
 *     Hooks::load( $this );
 *   }
 * 
 *   public function filterTitle() {
 *     return 'Das ist mein Seitentitel';
 *   }
 * }
 * 
 * @method Hooks instance() Returns Hooks class instance.
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
    protected $assignedObject;

    /**
     * Hooks
     * 
     * @var array
     * 
     * @since 1.0.0
     */
    protected $hooks = [];

    /**
     * Add Hook. 
     * 
     * Can be also be used outside of a class for clearer overview.
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
            return $this;
        }

        $this->hooks[] = $hook;

        return $this;
    }

    /**
     * Load Hooks of an object.
     * 
     * Needs to be executed in class which contains hooks to add.
     * 
     * @param object Referenced object.
     * 
     * @since 1.0.0
     */
    public function load( object $object ) {
        $this->loadHooks( $object );
    }

    /**
     * Loading all hooks of an object.
     * 
     * @param object Referenced object.
     * 
     * @since 1.0.0
     */
    private function loadHooks( object $object ) {
        foreach( $this->hooks AS $i => $hook ) {
            if( $this->loadHook( $hook , $object) ) {
                unset( $this->hooks[ $i ] ); // Load hook only once and remove it after successful load.
            }
        }
    }

    /**
     * Load hook if assigned to current class.
     * 
     * @param HookInterface
     * @param object Referenced object.
     * 
     * @return bool True if hook was loaded succesful, false if not.
     * 
     * @since 1.0.0
     */
    private function loadHook( Hook $hook, object $object ) {
        // Only execute on same object/class
        if ( get_class( $object ) !== $hook->getCallbackClass() ) {
            return false;
        }

        $reflectionMethod = new \ReflectionMethod( $hook->getCallbackClass(), $hook->getCallbackMethod() );

        // If method is not static take object for hook callback.
        if ( ! $reflectionMethod->isStatic() ) {
            $callbackInstance = $object; 
        } else {
            $callbackInstance = $hook->getCallbackClass(); 
        }

        $hookMethod = 'add_' . $hook->getType();
        $hookArgs   = array_merge( [ $hook->getTag() ], [ [ $callbackInstance, '_Hook' . $hook->getCallbackMethod() ] ], $hook->getArgs() );

        call_user_func_array( $hookMethod, $hookArgs );

        return true;
    }
}