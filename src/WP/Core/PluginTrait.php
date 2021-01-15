<?php

namespace AWSM\LibWP\WP\Core;

/**
 * Abstract Plugin class.
 * 
 * @since 1.0.0
 */
trait PluginTrait
{
    /**
     * Plugin object.
     * 
     * @var Plugin
     */
    private $plugin;

    /**
     * Plugin access.
     * 
     * @return Plugin Plugin object.
     * 
     * @since 1.0.0
     */
    public function plugin() 
    {
        return $this->plugin;
    }
}