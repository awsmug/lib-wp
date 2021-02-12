<?php

namespace AWSM\LibWP\WP\Hooks;

use AWSM\LibWP\WP\Core\Plugin;
use AWSM\LibWP\WP\Core\PluginTrait;

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
    use PluginTrait;

    /**
     * Assigned objects.
     * 
     * @var string
     * 
     * @since 1.0.0
     */
    protected $assignedObject;

    /**
     * Hooks.
     * 
     * @var array
     * 
     * @since 1.0.0
     */
    protected $hooks = [];

    /**
     * Constructor.
     * 
     * @since 1.0.0
     */
    public function __construct( Plugin $plugin )
    {
        $this->plugin = $plugin;
    }

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
    public function add( HookInterface $hook, bool $check = true ) 
    {
        if( ! $check ) {
            return $this;
        }

        $this->hooks[] = $hook;

        $this->loadHook( $hook );

        return $this;
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
    private function loadHook( Hook $hook ) 
    {
        $hookMethod = 'add_' . $hook->getType();

        $hookArgs = [
            $hook->getTag(),
            [ $hook->getCallbackClass(), '__hook_' . $hook->getCallbackMethod() ],
            $hook->getPriority(),
            $hook->getAcceptedArgs()
        ];

        call_user_func_array( $hookMethod, $hookArgs );

        return true;
    }
}