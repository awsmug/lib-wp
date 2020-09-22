<?php

use PHPUnit\Framework\TestCase;

use AWSM\SystemLayer\Tools\CallerDetective;

final class CallerDetectiveTest extends TestCase {
	public function testFunction(): void {
		$this->assertEquals( 'testFunction', CallerDetective::detect()->functionName() );
        $this->assertFalse( CallerDetective::detect()->functionHasArgs() );
       
	}

	public function testClass(): void {
		$this->assertTrue( CallerDetective::detect()->isClass() );
		$this->assertEquals( 'CallerDetectiveTest', CallerDetective::detect()->className() );
	}
}