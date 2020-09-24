<?php

namespace AWSM\LibWP\WP\Hooks;

/**
 * WordPress Action Callback Interface
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
    protected $accepted_args;

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
    public function __construct( string $tag, array $callback, int $priority = 10, $accepted_args = 1 )
    {
        $this->tag           = $tag;
        $this->callback      = $callback;
        $this->priority      = $priority;
        $this->accepted_args = $accepted_args;
    }

    /**
    * Type of hook (filter/action)
    * 
    * @return string
    * 
    * @since 1.0.0
    */
    public final function type() : string
    {
        return $this->type;
    }

    /**
     * Callback
     * 
     * @var string
     * 
     * @since 1.0.0
     */
    public final function callback() : array 
    {
        return $this->callback;
    }

    /**
     * Arguments
     * 
     * @var array
     * 
     * @since 1.0.0
     */
    public final function args() : array 
    {
        return [
            $this->tag,
            $this->callback,
            $this->priority,
            $this->accepted_args
        ];
    }
}