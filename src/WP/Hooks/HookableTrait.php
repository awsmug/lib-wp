<?php

namespace AWSM\LibWP\WP\Hooks;

use AWSM\LibWP\WP\Core\PluginTrait;
use AWSM\LibWP\WP\ExceptionCatcher;
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
    use PluginTrait;

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

        $reflectMethod = new \ReflectionMethod( $className , $methodName );
        
        try {
            if ( $reflectMethod->isPrivate() && ! in_array( $methodName, $this->hookableHiddenMethods ) ) {
                throw new Exception( sprintf( 'Can\'t call method "%s". Called method %s is private and not set hookable. Set it hookable via setHookableHiddenMethods method in class "%s".', $className . '::' . $methodName, $className ) );
            }

            if( $reflectMethod->isStatic() ) {
                return call_user_func_array( [ $className, $methodName ], $args  );
            } else {
                return call_user_func_array( [ $this, $methodName ], $args  );
            }            
        } catch ( Exception $e ) {      
            $this->plugin()->exceptionCatcher()->error( sprintf( 'Error executing call %s: %s', $className . '::' . $methodName, $e->getMessage() ) );
        }
	}
}