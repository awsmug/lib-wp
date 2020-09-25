<?php

namespace AWSM\LibWP\WP\Hooks;

/**
 * Trait hookableHiddenMethods.
 *
 * This design approach lets set functions to private which have to be hooked into wordpress,
 * which has inheritance reasons. Not all child classes should have access to hooked functions.
 *
 * @package Awsm\WP_Wrapper\Traits
 *
 * @since 1.0.0
 */
trait HookableHiddenMethodsTrait {
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
	 * @param array $functions
	 *
	 * @since 1.0.0
	 */
	protected function setHookableHiddenMethods( array $functions  ) {
		$this->hookableHiddenMethods = $functions;
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
		if( ! in_array( $name, $this->hookableHiddenMethods ) ) {
			return;
		}

		return call_user_func_array( [ $this, $name ], $args  );
	}
}