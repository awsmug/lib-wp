<?php

use AWSM\SystemLayer\WP\Action;
use PHPUnit\Framework\TestCase;

use AWSM\SystemLayer\WP\Hooks;

require 'Assets/HooksTestSettings.php';

final class HooksTest extends TestCase {
	public function testFunction(): void {
        $instance = Hooks::instance()->add( new Action( 'wp_footer', [ HooksTestSettings::class, 'filter' ] ) );

        $this->assertInstanceOf( Hooks::class, $instance );
	}
}