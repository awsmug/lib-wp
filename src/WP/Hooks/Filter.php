<?php

namespace AWSM\WP\WP\Hooks;

/**
 * WordPress Filter Callback Interface
 */
class Filter implements HookInterface {
    protected $tag;
    protected $callback;
    protected $priority;
    protected $accepted_args;

    public function __construct( $tag, $priority = 10, $accepted_args = 1 )
    {
        $this->type          = 'filter';

        $this->tag           = $tag;
        $this->priority      = $priority;
        $this->accepted_args = $accepted_args;
    }

    public function callback( $callback ) : void {
        $this->callback = $callback;
    }

    public function method() : string
    {
        return 'add_action';
    }

    public function args() : array {
        return [
            $this->tag,
            $this->callback,
            $this->priority,
            $this->accepted_args
        ];
    }
}