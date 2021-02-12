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
    * Get tag of hook
    * 
    * @return string
    * 
    * @since 1.0.0
    */
    public function getTag() : string;

    /**
     * Get callback class
     * 
     * @var string
     * 
     * @since 1.0.0
     */
    public function getCallbackClass() : string;

    /**
     * Get callback method
     * 
     * @var string
     * 
     * @since 1.0.0
     */
    public function getCallbackMethod() : string;

    /**
     * Get hook priority.
     * 
     * @return int Hook priority.
     * 
     * @since 1.0.0
     */
    public function getPriority() : int;

    /**
     * Get number of accepted arguments.
     * 
     * @return int Number of accepted arguments.
     * 
     * @since 1.0.0
     */
    public function getAcceptedArgs() : int;
}