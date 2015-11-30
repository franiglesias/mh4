<?php

namespace AppBundle\Tests\Domain\It\Device\DeviceStates;

use AppBundle\Domain\It\Device\DeviceStates\RepairingDeviceState;

class RepairingDeviceStateTest extends \PHPUnit_Framework_Testcase {
	
	/**
	 * @expectedException \OutOfBoundsException
	 *
	 */
	public function testInstallThrowsException()
	{
		$State = new RepairingDeviceState();
		$State->install();
	}
	
	/**
	 * @expectedException \OutOfBoundsException
	 *
	 */
	public function testRepairThrowsException()
	{
		$State = new RepairingDeviceState();
		$State->sendToRepair();
	}
	
	public function testReparingDeviceCanBeFixed()
	{
		$State = new RepairingDeviceState();
		$this->assertInstanceOf('AppBundle\Domain\It\Device\DeviceStates\ActiveDeviceState', $State->fix());
	}
	

	public function testAReparingDeviceCanBeRetired()
	{
		$State = new RepairingDeviceState();
		$this->assertInstanceOf('AppBundle\Domain\It\Device\DeviceStates\RetiredDeviceState', $State->retire());;

	}
}

?>