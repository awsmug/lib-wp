<?php

namespace AWSM\LibWP\WP\Hooks;

/**
 * WordPress Action Callback Interface
 */
class Action implements HookInterface {
    protected $type;
    protected $tag;
    protected $callback;
    protected $priority;
    protected $accepted_args;

    public function __construct( string $tag, array $callback, int $priority = 10, $accepted_args = 1 )
    {
        $this->type          = 'action';

        $this->tag           = $tag;
        $this->callback      = $callback;
        $this->priority      = $priority;
        $this->accepted_args = $accepted_args;
    }

    public function type() : string
    {
        return $this->type;
    }

    public function callback( array $callback = array() ) : array 
    {
        if ( !empty( $callback ) ) {
            $this->callback = $callback;
        }

        return $this->callback;
    }

    public function args() : array 
    {
        return [
            $this->tag,
            $this->callback,
            $this->priority,
            $this->accepted_args
        ];
    }
}