<?php

namespace AWSM\LibWP\WP\Hooks;

use AWSM\LibWP\WP\Core\PluginTrait;
use Exception;

/**
 * Trait HookableTrait.
 *
 * This trait have to be used 
 *
 * @package Awsm\WP_Wrapper\Traits
 *
 * @since 1.0.0
 */
trait HookableTrait {
    /**
	 * Hookable hidden methods.
	 *
	 * @var array
	 *
	 * since 1.0.0
	 */
	private $hookableHiddenMethods = [];

	/**
	 * Set hookable hidden methods.
	 *
	 * @param array $functions An array of methods names in class.
	 *
	 * @since 1.0.0
	 */
	protected function setHookableHiddenMethods( array $methods  ) {
		$this->hookableHiddenMethods = $methods;
    }

    /**
     * Check if is Hookable hidden method.
     * 
     * @param  string $methodName Method name.
     * @return bool   True if method is a hookable hidden method.
     * 
     * @since 1.0.0
     */
    protected function isHookableHiddenMethod( string $methodName ) {
        return in_array( $methodName, $this->hookableHiddenMethods );
    }
    
	/**
	 * Magic call method.
	 *
	 * @param $name
	 * @param $args
	 *
	 * @return mixed
	 *
	 * @since 1.0.0
	 */
	public function __call( $name, $args ) {
        if( substr( $name, 0, 7 ) !== '__hook_' ) {
            return;
        }

        $className = get_called_class();
        $methodName  = substr( $name, 7, strlen( $name ) );       
        
        try {
            if ( ! in_array( PluginTrait::class, array_keys( ( new \ReflectionClass( get_called_class() ) )->getTraits() ) ) ) {
                trigger_error( sprintf( 'Missing PluginTrait in class "%s".', get_called_class() ), E_USER_ERROR );
            }

            $reflectMethod = new \ReflectionMethod( $className , $methodName );

            if ( $reflectMethod->isPrivate() && ! $this->isHookableHiddenMethod( $methodName ) ) {
                throw new Exception( sprintf( 'Can\'t call method "%s". Called method %s is private and not set hookable. Set it hookable via setHookableHiddenMethods method in class "%s".', $className . '::' . $methodName, $className ) );
            }

            $hasArgs = ! count( $args ) === 0;

            if ( $reflectMethod->isStatic() ) {
                $class = $className;
            } else {
                $class = $this;
            }

            if ( $hasArgs ) {
                return call_user_func_array( [ $class, $methodName ], $args  );
            } else {
                return call_user_func( [ $class, $methodName ] );
            }

        } catch ( Exception $e ) {    
            $this->plugin()->exceptionCatcher()->error( sprintf( 'Error executing call %s: %s', $className . '::' . $methodName, $e->getMessage() ) );
        }
	}
}