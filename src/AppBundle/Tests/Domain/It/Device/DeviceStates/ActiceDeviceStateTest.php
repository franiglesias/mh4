<?php

namespace AppBundle\Tests\Domain\It\Device\DeviceStates;

use AppBundle\Domain\It\Device\DeviceStates\ActiveDeviceState;

class ActiveDeviceStateTest extends \PHPUnit_Framework_Testcase {
	
	/**
	 * @expectedException \OutOfBoundsException
	 *
	 */
	public function testInstallThrowsException()
	{
		$State = new ActiveDeviceState();
		$State->install();
	}
	
	public function testCanRepairActiveDevices()
	{
		$State = new ActiveDeviceState();
		$this->assertInstanceOf('AppBundle\Domain\It\Device\DeviceStates\RepairingDeviceState', $State->repair());
	}
	
	/**
	 * @expectedException \OutOfBoundsException
	 *
	 */
	public function testFixThrowsException()
	{
		$State = new ActiveDeviceState();
		$State->fix();
	}
	
	public function testCanRetireActiveDevices()
	{
		$State = new ActiveDeviceState();
		$this->assertInstanceOf('AppBundle\Domain\It\Device\DeviceStates\RetiredDeviceState', $State->retire());;
	}
}

?>