<?php

namespace AWSM\SystemLayer;

/**
 * Class Hook.
 * 
 * @since 1.0.0
 */
interface CallbackInterface {
    public function onCall( array $arguments ) : void;
    public function method() : string;
    public function args() : array;
}