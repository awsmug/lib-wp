<?php

use AWSM\LibWP\WP\Core\WP;
use PHPUnit\Framework\TestCase;

require 'Assets/WP.php';

final class WPTest extends TestCase {
	public function testFunction(): void {
        $this->assertEquals( '/var/www/', WP::dir() );

        $path     = '/var/www/wp-content/plugins/myplugin/assets/dist/js/index.js';
        $pathDiff = 'wp-content/plugins/myplugin/assets/dist/js/index.js';
        $url      = 'https://local.test/wp-content/plugins/myplugin/assets/dist/js/index.js';

        $this->assertEquals( $pathDiff, WP::getPathDiff( $path ) );
        $this->assertEquals( $url, WP::getUrl( $path ) );
	}
}