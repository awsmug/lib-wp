<?php

namespace AWSM\SystemLayer;

use AWSM\SystemLayer\WP\Action;
use AWSM\SystemLayer\WP\Filter;
use AWSM\SystemLayer\WP\WP;

/**
 * Class Hook.
 * 
 * @since 1.0.0
 */
class Hooks {
    protected $mappings = [];

    public function __construct()
    {
        
    }

    public function map( string $trigger, string $className, string $methodName, CallbackInterface $callback ) {
        $this->mappings[ $trigger ][] = [
            'className'  => $className,
            'methodName' => $methodName,
            'callback'   => $callback
        ];

        return $this;
    }

    public function trigger( string $trigger ) {
       $mapping = $this->mappings[ $trigger ];

       foreach( $mapping AS $callback ) {
           $callback->onCall( $callback['methodName'] );
           call_user_func_array( $callback->method(), $callback->params() );
       }
    }

    public function assign() {
        
    }
}

$hooks = new Hooks();
$hooks->map( 'AfterUserAgreed', GoogleScripts::class, 'showBanner', new Action( 'sidebar' ) )
        ->map( 'AfterUserAgreed', GoogleScripts::class, 'setTitle', new Filter( 'wp_title' ) )
        ->map( 'AfterUserAgreed', GoogleScripts::class, 'addScripts', new Action( 'wp_footer' ) );

class MyClass {
    private $hooks;

    public function __construct( Hooks $hooks )
    {
        $this->hooks = $hooks;
    }

    public function userAgreed() {
        $this->hooks->trigger('AfterUserAgreed');
    }

    public function setTitle() {
        return 'The new site title';
    }

    public function showBanner() {
        echo '<img />';
    }

    public function addScripts() {
        echo '<script />';
    }
}