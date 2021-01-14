<?php

namespace AWSM\LibWP\WP\Hooks;

use AWSM\LibWP\WP\Core\AdminNotices;
use AWSM\LibWP\WP\ExceptionCatcher;
use Exception;

/**
 * Trait Hookable.
 *
 * This trait have to be used 
 *
 * @package Awsm\WP_Wrapper\Traits
 *
 * @since 1.0.0
 */
trait Hookable {
    /**
	 * Hookable hidden methods.
	 *
	 * @var array
	 *
	 * since 1.0.0
	 */
	private $hookableHiddenMethods;

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
        if( ! substr( $name, 0, 6 ) === '_Hook' ) {
            return;
        }

        $className = get_called_class();
        $methodName  = substr( $name, 6, strlen( $name ) );

        $reflectMethod = new \ReflectionMethod( $className , $methodName );

        if ( $reflectMethod->isPrivate() && ! in_array( $methodName, $this->hookableHiddenMethods ) ) {
			return;
		}
        
        try {
            if( $reflectMethod->isStatic() ) {
                return call_user_func_array( [ $className, $methodName ], $args  );
            } else {
                return call_user_func_array( [ $this, $methodName ], $args  );
            }            
        } catch ( Exception $e ) {            
            ExceptionCatcher::error( sprintf( 'Error executing call %s. Error message: %s', $methodName, $e->getMessage() ) );
        }
	}
}