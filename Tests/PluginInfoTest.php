<?php

use AWSM\LibWP\WP\Core\PluginInfo;
use PHPUnit\Framework\TestCase;

final class PluginInfoTest extends TestCase {
	public function testFunction(): void {
        $pi = new PluginInfo( dirname( __FILE__ ) . '/Assets/Plugin.php' );

        $this->assertEquals('My Plugin', $pi->getName() );
        $this->assertEquals('A wonderfull plugin.', $pi->getDescription() );
        $this->assertEquals('Sven Wagener', $pi->getAuthor() );
        $this->assertEquals('https://sven-wagener.com', $pi->getAuthorURI() );
        $this->assertEquals('1.2.3', $pi->getVersion() );
        $this->assertEquals('myplgin', $pi->getTextDomain() );
        $this->assertEquals('/assets/langauges/', $pi->getDomainPath() );
        $this->assertTrue( $pi->getNetwork() );
        $this->assertEquals('5.4.0', $pi->getRequiredWPVersion() );
        $this->assertEquals('7.1.0', $pi->getRequiredPHPVersion() );
	}
}