<?php

namespace AppBundle\Tests\Domain\It\Device;

use AppBundle\Domain\It\Device\Device;
use AppBundle\Domain\It\Device\ValueObjects\DeviceId;
use AppBundle\Domain\It\Device\ValueObjects\DeviceVendor;
use AppBundle\Domain\It\Device\ValueObjects\DeviceLocation;
use AppBundle\Domain\It\Device\ValueObjects\DeviceName;
use AppBundle\Domain\It\Device\ValueObjects\DeviceFailure;
use AppBundle\Domain\It\Device\ValueObjects\DeviceTechnician;

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

	public function test_Acquire_Device_Generates_Device_Was_Acquired_Event()
	{
		$Device = Device::acquire(new DeviceId(1), new DeviceName('Computer'), new DeviceVendor('Apple', 'iMac'));
		$events = $Device->getRecordedEvents();
		$this->assertEquals(1, count($events));
		$this->assertInstanceOf('AppBundle\Domain\It\Device\Events\DeviceWasAcquired', $events[0]);
		return $Device;
	}
	
	/**
	 * @depends test_Acquire_Device_Generates_Device_Was_Acquired_Event
	 * @expectedException OutOfBoundsException
	 * @param Device $Device 
	 */
	public function test_Not_Installed_Device_Can_not_be_moved(Device $Device)
	{
		$Device->move(new DeviceLocation('Classroom'));
	}
	
	
	/**
	 * @depends test_Acquire_Device_Generates_Device_Was_Acquired_Event
	 *
	 * @param Device $Device 
	 */
	public function test_Install_Device_Generates_Device_Was_Installed_Event(Device $Device)
	{
		$Device->install(new DeviceLocation('Classroom'));
		$events = $Device->getRecordedEvents();
		$this->assertEquals(2, count($events));
		$this->assertInstanceOf('AppBundle\Domain\It\Device\Events\DeviceWasInstalled', $events[1]);
		return $Device;
	}
	
	/**
	 * @depends test_Install_Device_Generates_Device_Was_Installed_Event
	 * @expectedException OutOfBoundsException
	 * @param Device $Device 
	 */	
	public function test_Installed_Device_Can_Not_Be_Installed_Again(Device $Device)
	{
		$Device->install(new DeviceLocation('Another Classroom'));
	}

	/**
	 * @depends test_Install_Device_Generates_Device_Was_Installed_Event
	 * @param Device $Device 
	 */	
	public function test_Installed_Device_Can_Be_Moved_To_Another_Location(Device $Device)
	{
		$Device->move(new DeviceLocation('Another Location'));
		$events = $Device->getRecordedEvents();
		$this->assertEquals(3, count($events));
		$this->assertInstanceOf('AppBundle\Domain\It\Device\Events\DeviceWasMoved', $events[2]);
		return $Device;
	}
	
	/**
	 * @depends test_Installed_Device_Can_Be_Moved_To_Another_Location
	 * @param Device $Device 
	 */	
	public function test_Move_To_The_Same_Location_Does_Nothing(Device $Device)
	{
		$Device->move(new DeviceLocation('Another Location'));
		$events = $Device->getRecordedEvents();
		$this->assertEquals(3, count($events));
		$this->assertInstanceOf('AppBundle\Domain\It\Device\Events\DeviceWasMoved', $events[2]);
		return $Device;
	}
	
	/**
	 * @depends test_Installed_Device_Can_Be_Moved_To_Another_Location
	 * @param Device $Device 
	 */	
	public function test_Installed_Device_Can_Fail(Device $Device)
	{
		$Device->fail(new DeviceFailure('A fail', 'User', new \DateTimeImmutable()));
		$events = $Device->getRecordedEvents();
		$this->assertEquals(4, count($events));
		$this->assertInstanceOf('AppBundle\Domain\It\Device\Events\DeviceFailed', $events[3]);
		return $Device;
	}
	
	/**
	 * @depends test_Installed_Device_Can_Fail
	 *
	 * @param Device $Device 
	 */
	public function test_Failed_Device_Can_Be_Send_To_Repair(Device $Device)
	{
		$Device->sendToRepair(new DeviceFailure('A fail', 'User', new \DateTimeImmutable()), new DeviceTechnician('SAT'));
		
	}
	
	
}

?>