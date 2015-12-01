<?php

namespace AppBundle\Tests\Domain\It\Device;

use AppBundle\Domain\It\Device\Device;
use AppBundle\Domain\It\Device\ValueObjects\VendorInformation;
use AppBundle\Domain\It\Device\ValueObjects\Installation;
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
		$Device = Device::register('Device', new VendorInformation('Apple', 'iMac', '001'));
		$this->assertAttributeEquals('Device', 'name', $Device);
		return $Device;
	}
	
		/**
		 * @depends testDeviceRegister
		 *
		 */
		public function testRegisteredDeviceSetsVendor(Device $Device)
		{
			$this->assertAttributeEquals(new VendorInformation('Apple', 'iMac', '001'), 'vendor', $Device);
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
		$Device = Device::register('Device', new VendorInformation('Apple', 'iMac', 'Serial'));
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
		$Device = Device::register('Device', new VendorInformation('Apple', 'iMac', 'Serial'));
		$Device->install(new Installation(null, new \DateTimeImmutable()));
	}
	
}

?>