<?php

namespace AppBundle\Tests\Domain\It\Device\DeviceStates;

use AppBundle\Domain\It\Device\DeviceStates\UninstalledDeviceState;

class UninstalledDeviceStateTest extends \PHPUnit_Framework_Testcase {
	
	public function testInstallReturnsActiveDeviceState()
	{
		$State = new UninstalledDeviceState();
		$this->assertInstanceOf('AppBundle\Domain\It\Device\DeviceStates\ActiveDeviceState', $State->install());
	}
	
	/**
	 * @expectedException \OutOfBoundsException
	 *
	 */
	public function testRepairThrowsException()
	{
		$State = new UninstalledDeviceState();
		$State->repair();
	}
	
	/**
	 * @expectedException \OutOfBoundsException
	 *
	 */
	public function testFixThrowsException()
	{
		$State = new UninstalledDeviceState();
		$State->fix();
	}
	
	/**
	 * @expectedException \OutOfBoundsException
	 *
	 */
	public function testRetireThrowsException()
	{
		$State = new UninstalledDeviceState();
		$State->retire();
	}
}

?>