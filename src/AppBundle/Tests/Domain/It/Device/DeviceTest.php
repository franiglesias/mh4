<?php

namespace AppBundle\Tests\Domain\It\Device;

use AppBundle\Domain\It\Device\Device;
use AppBundle\Domain\It\Device\ValueObjects\DeviceVendor;
use AppBundle\Domain\It\Device\ValueObjects\DeviceLocation;
use AppBundle\Domain\It\Device\DTO\DeviceRegisterDTO;
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

	public function testDeviceRegister()
	{
		$Device = Device::register('Device', new DeviceVendor('Apple', 'iMac', '001'));
		$this->assertAttributeEquals('Device', 'name', $Device);
		return $Device;
	}
	
		/**
		 * @depends testDeviceRegister
		 *
		 */
		public function testRegisteredDeviceSetsAVendor(Device $Device)
		{
			$this->assertAttributeEquals(new DeviceVendor('Apple', 'iMac', '001'), 'vendor', $Device);
		}

		/**
		 * @depends testDeviceRegister
		 *
		 */
		public function testRegisteredDeviceHasUninstalledState(Device $Device)
		{
			$this->assertAttributeEquals(new UninstalledDeviceState(), 'state', $Device);
		}


	public function testDevicesAreInstalledInALocationOnADate()
	{
		$Device = Device::register('Device', new DeviceVendor('Apple', 'iMac', 'Serial'));
		$Device->install(new DeviceLocation('Location', new \DateTimeImmutable()));
		$this->assertAttributeEquals(new DeviceLocation('Location', new \DateTimeImmutable()), 'installation', $Device);
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
			$Device->moveTo(new DeviceLocation('New Location', new \DateTimeImmutable()));
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

	/**
	 * @expectedException \InvalidArgumentException
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function testALocationMustBeProvided()
	{
		$Device = Device::register('Device', new DeviceVendor('Apple', 'iMac', 'Serial'));
		$Device->install(new DeviceLocation(null, new \DateTimeImmutable()));
	}
	
}

?>