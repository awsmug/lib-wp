<?php

namespace AWSM\LibWP\WP\Hooks;

/**
 * Class Hook.
 * 
 * @since 1.0.0
 */
interface HookInterface {
    /**
    * Get type of hook (filter/action)
    * 
    * @return string
    * 
    * @since 1.0.0
    */
    public function getType() : string;

    /**
     * Get callback
     * 
     * @var string
     * 
     * @since 1.0.0
     */
    public function getCallback() : array;

    /**
     * Get arguments
     * 
     * @var array
     * 
     * @since 1.0.0
     */
    public function getArgs() : array;
}