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
    protected $plugin;

    /**
     * Plugin access.
     * 
     * @return Plugin Plugin object.
     * 
     * @since 1.0.0
     */
    public function plugin() : Plugin
    {
        return $this->plugin;
    }
}