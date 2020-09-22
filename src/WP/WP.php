<?php

namespace AWSM\SystemLayer\WP;

class WP {
    public static function action( string $action_name, int $priority = 10, int $argument_count = 1 ) {
        return new Action( $action_name, $priority, $argument_count );
    }

    public static function filter( string $filter_name, int $priority = 10, int $argument_count = 1 ) {
        
    }
}