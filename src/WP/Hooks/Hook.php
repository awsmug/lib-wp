<?php

namespace AWSM\LibWP\WP\Hooks;

use AWSM\LibWP\WP\WPException;

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
     * Get callback
     * 
     * @var string
     * 
     * @since 1.0.0
     */
    public final function getCallback() : array 
    {
        $reflectionMethod = new \ReflectionMethod( $this->callback[0], $this->callback[1] );

        // If method is not static take object for hook callback.
        if ( ! $reflectionMethod->isStatic() ) {
            $this->callback[0] = $this->assignedObject; 
        }

        return $this->callback;
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
            $this->tag,
            $this->getCallback(),
            $this->priority,
            $this->acceptedArgs
        ];
    }
}