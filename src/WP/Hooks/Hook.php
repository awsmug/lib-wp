<?php

namespace AWSM\LibWP\WP\Hooks;

use stdClass;

/**
 * WordPress Hooks
 * 
 * @since 1.0.0
 */
abstract class Hook implements HookInterface {
    /**
     * Type of hook (filter/action)
     * 
     * @var string
     * 
     * @since 1.0.0
     */
    protected $type;

    /**
     * Hook tag
     * 
     * @var string
     * 
     * @since 1.0.0
     */
    protected $tag;

    /**
     * Callback
     * 
     * @var array
     * 
     * @since 1.0.0
     */
    protected $callback;

    /**
     * Priority of hook
     * 
     * @var int
     * 
     * @since 1.0.0
     */
    protected $priority;

    /**
     * Number of accepted arguments
     * 
     * @var int
     * 
     * @since 1.0.0
     */
    protected $acceptedArgs;

    /**
     * Constructor
     * 
     * @param string $tag Hook tag
     * @param array  $callback Callback
     * @param int    $priority Priority of hook
     * @param int    $accepted_args Number of accepted arguments.
     * 
     * @since 1.0.0
     */
    public function __construct( string $tag, array $callback, int $priority = 10, int $acceptedArgs = 1 )
    {
        $this->tag           = $tag;
        $this->callback      = $callback;
        $this->priority      = $priority;
        $this->acceptedArgs = $acceptedArgs;
    }

    /**
    * Get type of hook (filter/action)
    * 
    * @return string
    * 
    * @since 1.0.0
    */
    public final function getType() : string
    {
        return $this->type;
    }

    /**
    * Get tag of hook 
    * 
    * @return string
    * 
    * @since 1.0.0
    */
    public final function getTag() : string
    {
        return $this->tag;
    }

    /**
     * Callback
     * 
     * @return array Callback.
     * 
     * @since 1.0.0
     */
    public function getCallBack() : array {
        return $this->callback;
    }

    /**
     * Get callback class
     * 
     * @return string Callback class
     * 
     * @since 1.0.0
     */
    public function getCallbackClass()
    {
        return $this->callback[0];
    }

    /**
     * Get callback method
     * 
     * @return string Callback method
     * 
     * @since 1.0.0
     */
    public function getCallbackMethod() : string
    {
        return $this->callback[1];
    }

    /**
     * Get hook priority.
     * 
     * @return int Hook priority.
     * 
     * @since 1.0.0
     */
    public function getPriority() : int {
        return $this->priority;
    }

    /**
     * Get number of accepted arguments.
     * 
     * @return int Number of accepted arguments.
     * 
     * @since 1.0.0
     */
    public function getAcceptedArgs() : int {
        return $this->acceptedArgs;
    }
}