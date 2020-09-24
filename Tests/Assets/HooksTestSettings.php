<?php

use AWSM\WP\WP\Hooks\Hooks;

class HooksTestSettings {
    public function __construct()
    {
        Hooks::assign( $this );
    }

    public function filter() {
    }

    public function test() {
    }
}