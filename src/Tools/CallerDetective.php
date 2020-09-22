<?php

namespace AWSM\SystemLayer\Tools;

use Exception;

/**
 * Caller Detective
 * 
 * @since 1.0.0
 */
class CallerDetective {
    /**
     * Trace data of call.
     * 
     * @param array
     * 
     * @since 1.0.0
     */
    private $trace;

    /**
     * Depth of trace.
     * 
     * @param int
     * 
     * @since 1.0.0
     */
    private $depth;

    /**
     * Constructor
     * 
     * @param int $depth Level of detection.
     * 
     * @since 1.0.0
     */
    private function __construct( $depth ) {
        $exception   = new Exception();
        $this->trace = $exception->getTrace();

        $this->depth( $depth );
    }

    /**
     * Instantiation
     * 
     * @param int $depth Level of detection.
     * 
     * @return CallerDetective
     * 
     * @since 1.0.0
     */
    public static function detect( int $depth = 0 ) : CallerDetective {
        return new self( $depth );
    }

    /**
     * Set level of detection
     * 
     * @param int $depth Level of detection.
     * 
     * @throws \Exception If level not exists.
     * 
     * @since 1.0.0
     */
    private function depth( int $depth ) : void {
        $depth += 2;

        if ( ! array_key_exists( $depth ,$this->trace ) ) {
            throw new Exception('Too deep');
        }

        $this->depth = $depth;
    }

    /**
     * Determines if caller is a class.
     * 
     * @return bool 
     * 
     * @since 1.0.0
     */
    public function isClass() : bool {       
        if ( ! array_key_exists( 'class',$this->trace[ $this->depth ] ) ) {
            return false;
        }

        return true;
    }

    /**
     * Return class name
     * 
     * @return string Class name.
     * 
     * @since 1.0.0
     */
    public function className() : string {
        if( ! $this->isClass() ) {
            return '';
        }

        return $this->trace[ $this->depth ]['class'];
    }

    /**
     * Caller function name.
     * 
     * @return string function name.
     * 
     * @since 1.0.0
     */
    public function functionName() : string {
        return $this->trace[ $this->depth ]['function'];
    }

    /**
     * Determines if caller has arguments.
     * 
     * @return bool True if caller has arguments, false if not.
     * 
     * @since 1.0.0
     */
    public function functionHasArgs() : bool { 
        $trace = $this->trace[ $this->depth ];

        if ( ! array_key_exists( 'args', $trace ) ) {
            return false;
        }

        if ( is_array( $trace['args'] ) && count( $trace['args'] ) === 0 ) {
            return false;
        } 

        return true;
    }

    /**
     * Caller function name.
     * 
     * @return string function name.
     * 
     * @since 1.0.0
     */
    public function functionArgs() : array {
        if( ! $this->functionHasArgs() ) {
            return array();
        }

        return $this->trace[ $this->depth ]['args'];
    }
}
