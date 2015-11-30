<?php

namespace AppBundle\Tests\Domain\It\Device;

use AppBundle\Domain\It\Device\Device;
use AppBundle\Domain\It\Device\VendorInformation;
use AppBundle\Domain\It\Device\Installation;
use AppBundle\Domain\It\Device\DeviceStates\UninstalledDeviceState;
use AppBundle\Domain\It\Device\DeviceStates\ActiveDeviceState;
use AppBundle\Domain\It\Device\DeviceStates\RepairingDeviceState;
/**
* Description
*/
class DeviceTest extends \PHPUnit_Framework_Testcase
{
	public function testANewDeviceHasAName()
	{
		$Device = new Device('Device', new VendorInformation('Apple', 'iMac', 'Serial'));
		$this->assertAttributeEquals('Device', 'name', $Device);
		return $Device;
	}
	
	/**
	 * @depends testANewDeviceHasAName
	 *
	 */
	public function testANewDeviceHasVendorInformation(Device $Device)
	{
		$this->assertAttributeEquals(new VendorInformation('Apple', 'iMac', 'Serial'), 'vendor', $Device);
	}
	
	/**
	 * @depends testANewDeviceHasAName
	 *
	 */	
	public function testNewDeviceHasUninstalledState(Device $Device)
	{
		$this->assertAttributeEquals(new UninstalledDeviceState(), 'state', $Device);
	}
	
	/**
	 * @depends testANewDeviceHasAName
	 * @expectedException \OutOfBoundsException
	 */	
	public function testNewDeviceCannotBeSentToRepair(Device $Device)
	{
		$Device->sendToRepair();
	}

	/**
	 * @depends testANewDeviceHasAName
	 *
	 */	
	public function testNewDeviceCanBeInstalled(Device $Device)
	{
		$Device->install(new Installation('Location', new \DateTimeImmutable()));
		$this->assertAttributeEquals(new ActiveDeviceState(), 'state', $Device);
	}

	public function testDevicesAreInstalledInALocationOnADate()
	{
		$Device = new Device('Device', new VendorInformation('Apple', 'iMac', 'Serial'));
		$Device->install(new Installation('Location', new \DateTimeImmutable()));
		$this->assertAttributeEquals(new Installation('Location', new \DateTimeImmutable()), 'installation', $Device);
		return $Device;
	}

	/**
	 * @depends testDevicesAreInstalledInALocationOnADate
	 *
	 */		
	public function testCanAskADeviceWhereIsItInstalled(Device $Device)
	{
		$this->assertEquals('Location', $Device->where()->getLocation());
	}

	/**
	 * @depends testDevicesAreInstalledInALocationOnADate
	 *
	 */	
	public function testDeviceCanBeMoved(Device $Device)
	{
		$Device->moveTo(new Installation('New Location', new \DateTimeImmutable()));
		$this->assertEquals('New Location', $Device->where()->getLocation());
	}
	
	/**
	 * @depends testDevicesAreInstalledInALocationOnADate
	 *
	 */		
	public function testActiveDeviceCanFail(Device $Device)
	{
		$Device->fail();
		$this->assertAttributeEquals(new FailedDeviceState(), 'state', $Device);
	}
}

?>