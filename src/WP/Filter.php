<?php

namespace AWSM\SystemLayer\WP;

use AWSM\SystemLayer\CallbackInterface;

/**
 * WordPress Filter Callback Interface
 */
class Filter implements CallbackInterface {
    protected $tag;
    protected $callback;
    protected $priority;
    protected $accepted_args;

    public function __construct( $tag, $priority = 10, $accepted_args = 1 )
    {
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