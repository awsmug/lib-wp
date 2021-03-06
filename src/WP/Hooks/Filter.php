<?php

namespace AWSM\LibWP\WP\Hooks;

/**
 * WordPress filter callback interface
 * 
 * @since 1.0.0
 */
class Filter extends Hook {
/**
     * Constructor
     * 
     * @param string $tag Hook tag
     * @param array  $callback Callback
     * @param int    $priority Priority of hook
     * @param int    $acceptedArgs Number of accepted arguments.
     * 
     * @since 1.0.0
     */
    public function __construct( string $tag, array $callback, int $priority = 10, $acceptedArgs = 1 )
    {
        $this->type = 'filter';
        parent::__construct( $tag, $callback, $priority, $acceptedArgs );
    }
}