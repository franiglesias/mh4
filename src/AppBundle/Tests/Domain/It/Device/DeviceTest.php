<?php

namespace AppBundle\Tests\Domain\It\Device;

use AppBundle\Domain\It\Device\Device;
use AppBundle\Domain\It\Device\VendorInformation;
use AppBundle\Domain\It\Device\Installation;
use AppBundle\Domain\It\Device\Commands\DeviceRegisterCommand;
use AppBundle\Domain\It\Device\DeviceStates\UninstalledDeviceState;
use AppBundle\Domain\It\Device\DeviceStates\ActiveDeviceState;
use AppBundle\Domain\It\Device\DeviceStates\RepairingDeviceState;
use AppBundle\Domain\It\Device\DeviceStates\FailedDeviceState;
use AppBundle\Domain\It\Failure\Failure;

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
	
	
	public function testRegisterWithCommand()
	{
		$Device = Device::register(new DeviceRegisterCommand('Device', 'Apple', 'iMac', '001'));
		$this->assertAttributeEquals('Device', 'name', $Device);
		return $Device;
	}
	/**
	 * @depends testRegisterWithCommand
	 *
	 */
	public function testRegisteredDeviceSetsVendor(Device $Device)
	{
		$this->assertAttributeEquals(new VendorInformation('Apple', 'iMac', '001'), 'vendor', $Device);
	}

	/**
	 * @depends testRegisterWithCommand
	 *
	 */

	public function testRegisteredDeviceHasUninstalledState(Device $Device)
	{
		$this->assertAttributeEquals(new UninstalledDeviceState(), 'state', $Device);
	}

	public function testDevicesAreInstalledInALocationOnADate()
	{
		$Device = new Device('Device', new VendorInformation('Apple', 'iMac', 'Serial'));
		$Device->install(new Installation('Location', new \DateTimeImmutable()));
		$this->assertAttributeEquals(new Installation('Location', new \DateTimeImmutable()), 'installation', $Device);
		return $Device;
	}

	/**
	 * @expectedException \InvalidArgumentException
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function testALocationMustBeProvided()
	{
		$Device = new Device('Device', new VendorInformation('Apple', 'iMac', 'Serial'));
		$Device->install(new Installation(null, new \DateTimeImmutable()));
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
	public function testActiveDeviceCanFailWithAFailure(Device $Device)
	{
		$Device->fail(new Failure('Failure description'));
		$this->assertAttributeEquals(new FailedDeviceState(), 'state', $Device);
		return $Device;
	}
	/**
	 * @depends testActiveDeviceCanFailWithAFailure
	 *
	 */		
	public function testFailAddsFailureToFailureCollection(Device $Device)
	{
		$this->assertEquals(1, count($Device->getFailures()));
	}
	
}

?>