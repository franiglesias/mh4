<?php

namespace AppBundle\Tests\Domain\It\Device;

use AppBundle\Domain\It\Device\Device;
use AppBundle\Domain\It\Device\VendorInformation;
use AppBundle\Domain\It\Device\Installation;
use AppBundle\Domain\It\Device\DeviceStates\UninstalledDeviceState;
use AppBundle\Domain\It\Device\DeviceStates\ActiveDeviceState;
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
		$Device->repair();
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
}

?>