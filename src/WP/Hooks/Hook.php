<?php

namespace AWSM\LibWP\WP\Hooks;

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
    public function __construct( string $tag, array $callback, int $priority = 10, $acceptedArgs = 1 )
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
     * Get callback class
     * 
     * @return string Callback class
     * 
     * @since 1.0.0
     */
    public function getCallbackClass() : string
    {
        return get_class( $this->callback[0] );
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
     * Get arguments
     * 
     * @var array
     * 
     * @since 1.0.0
     */
    public final function getArgs() : array 
    {
        return [
            $this->priority,
            $this->acceptedArgs
        ];
    }
}