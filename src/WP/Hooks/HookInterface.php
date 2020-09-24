<?php

namespace AWSM\LibWP\WP\Hooks;

/**
 * Class Hook.
 * 
 * @since 1.0.0
 */
interface HookInterface {
    /**
    * Type of hook (filter/action)
    * 
    * @return string
    * 
    * @since 1.0.0
    */
    public function type() : string;

    /**
     * Callback
     * 
     * @var string
     * 
     * @since 1.0.0
     */
    public function callback() : array;

    /**
     * Arguments
     * 
     * @var array
     * 
     * @since 1.0.0
     */
    public function args() : array;
}