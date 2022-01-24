<?php

use AWSM\LibWP\WP\Hooks\Action;
use AWSM\LibWP\WP\Hooks\Hooks;
use PHPUnit\Framework\TestCase;

final class HooksTest extends TestCase {
        public function testFunction(): void {
        $instance = Hooks::instance()->add( new Action( 'wp_footer', [ HooksTestSettings::class, 'filter' ] ) );

        $this->assertInstanceOf( Hooks::class, $instance );
        }
}