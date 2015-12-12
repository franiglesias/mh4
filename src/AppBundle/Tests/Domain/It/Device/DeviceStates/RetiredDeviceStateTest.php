<?php

namespace AppBundle\Tests\Domain\It\Device\DeviceStates;

use AppBundle\Domain\It\Device\DeviceStates\RetiredDeviceState;

class RetiredDeviceStateTest extends \PHPUnit_Framework_Testcase {
	
	/**
	 * @expectedException \UnderflowException
	 *
	 */
	public function testInstallThrowsException()
	{
		$State = new RetiredDeviceState();
		$State->install();
	}
	
	/**
	 * @expectedException \UnderflowException
	 *
	 */
	public function testRepairThrowsException()
	{
		$State = new RetiredDeviceState();
		$State->sendToRepair();
	}
	
	/**
	 * @expectedException \UnderflowException
	 *
	 */
	public function testFixThrowsException()
	{
		$State = new RetiredDeviceState();
		$State->fix();
	}
	
	/**
	 * @expectedException \UnderflowException
	 *
	 */
	public function testRetireThrowsException()
	{
		$State = new RetiredDeviceState();
		$State->retire();
	}
}

?>