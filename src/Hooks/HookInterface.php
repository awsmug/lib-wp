<?php

namespace AWSM\SystemLayer\WP\Hooks;

/**
 * Class Hook.
 * 
 * @since 1.0.0
 */
interface HookInterface {
    public function type() : string;
    public function callback( array $callback = array() ) : array;
    public function args() : array;
}