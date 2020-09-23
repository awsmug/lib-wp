<?php

namespace AWSM\SystemLayer;

use AWSM\SystemLayer\Tools\CallerDetective;
use AWSM\SystemLayer\WP\Action AS WPAction;

/**
 * Class Triggers.
 * 
 * @since 1.0.0
 */
class Triggers {
    private static $instance = null;

    private $assignedClasses = [];

    protected $triggers = [];

    public static function setup() {
        if ( static::$instance === null ) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    public static function assign( &$object ) {
        self::setup()->assignedClasses[ get_class( $object ) ] = &$object;
    }

    public function add( string $name, CallbackInterface $callback, int $priority = 10 ) {
        $this->triggers[ $name ][ $priority ][] = [
            'callback'   => $callback,
        ];

        return $this;
    }

    public static function do( string $trigger ) {
        self::setup()->doCallbacks( $trigger );
    }

    private function doCallbacks( string $name ) {
        $triggers = $this->triggers[ $name ];

        foreach( $triggers AS $priorities ) {
            foreach ( $priorities AS $callbacks ) {
                foreach( $callbacks AS $callback ) {
                    $this->doCallback( $callback->method(), $callback->params() );
                }
            }
        }
    }

    private function doCallback( callable $callback, array $parameters ) {
        if ( is_array( $callback ) ) {
            if ( is_string( $callback[0] ) && CallerDetective::detect()->className() === $callback[0] ) {
                
            }
        }

        call_user_func_array( $callback, $parameters );
    }
}

$action = new WPAction( [ $this, 'show_banner'], 'sidebar' );

Triggers::setup()->add( 'AfterUserAgreed', [ $this, 'showBanner'], new WPAction( 'sidebar' ) );

Triggers::setup()->add( 'AfterUserAgreed', [ MyClass::class, 'showBanner'], new WPAction( 'sidebar' ) );



Triggers::do('AfterUserAgreed');

class MyClass {
    private $triggers;

    public function __construct( Triggers $triggers )
    {
        $this->triggers = $triggers;
    }

    public function userAgreed() {
        $this->triggers->trigger('AfterUserAgreed');
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



