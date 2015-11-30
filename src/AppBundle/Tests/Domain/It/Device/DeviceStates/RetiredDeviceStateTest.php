<?php

namespace AppBundle\Tests\Domain\It\Device\DeviceStates;

use AppBundle\Domain\It\Device\DeviceStates\RetiredDeviceState;

class RetiredDeviceStateTest extends \PHPUnit_Framework_Testcase {
	
	/**
	 * @expectedException \OutOfBoundsException
	 *
	 */
	public function testInstallThrowsException()
	{
		$State = new RetiredDeviceState();
		$State->install();
	}
	
	/**
	 * @expectedException \OutOfBoundsException
	 *
	 */
	public function testRepairThrowsException()
	{
		$State = new RetiredDeviceState();
		$State->repair();
	}
	
	/**
	 * @expectedException \OutOfBoundsException
	 *
	 */
	public function testFixThrowsException()
	{
		$State = new RetiredDeviceState();
		$State->fix();
	}
	
	/**
	 * @expectedException \OutOfBoundsException
	 *
	 */
	public function testRetireThrowsException()
	{
		$State = new RetiredDeviceState();
		$State->retire();
	}
}

?>