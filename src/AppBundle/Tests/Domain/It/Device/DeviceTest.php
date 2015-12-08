<?php

namespace AppBundle\Tests\Domain\It\Device;

use AppBundle\Domain\EventSourcing\RecordsEvents;

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
	private function assertDomainEventWasRecorded(RecordsEvents $RecordsEvents, $eventClass)
	{
		$events = $RecordsEvents->getRecordedEvents();
		$this->assertInstanceOf($eventClass, $events[count($events)-1]);
	}
		
	public function test_Acquire_Device()
	{
		$Device = Device::acquire(new DeviceId(1), new DeviceName('Computer'), new DeviceVendor('Apple', 'iMac'));
		$this->assertDomainEventWasRecorded($Device, 'AppBundle\Domain\It\Device\Events\DeviceWasAcquired');
		return $Device;
	}
	
	/**
	 * @depends test_Acquire_Device
	 * @expectedException OutOfBoundsException
	 * @param Device $Device 
	 */
	public function test_Not_Installed_Device_Can_not_be_moved(Device $Device)
	{
		$Device->move(new DeviceLocation('Classroom'));
	}
	
	
	/**
	 * @depends test_Acquire_Device
	 *
	 * @param Device $Device 
	 */
	public function test_Install_Device(Device $Device)
	{
		$Device->install(new DeviceLocation('Classroom'));
		$this->assertDomainEventWasRecorded($Device, 'AppBundle\Domain\It\Device\Events\DeviceWasInstalled');
		return $Device;
	}
	
	/**
	 * @depends test_Install_Device
	 * @expectedException OutOfBoundsException
	 * @param Device $Device 
	 */	
	public function test_Installed_Device_Can_Not_Be_Installed_Again(Device $Device)
	{
		$Device->install(new DeviceLocation('Another Classroom'));
	}

	/**
	 * @depends test_Install_Device
	 * @param Device $Device 
	 */	
	public function test_Installed_Device_Can_Be_Moved_To_Another_Location(Device $Device)
	{
		$Device->move(new DeviceLocation('Another Location'));
		$this->assertDomainEventWasRecorded($Device, 'AppBundle\Domain\It\Device\Events\DeviceWasMoved');
		return $Device;
	}
	
	/**
	 * @depends test_Installed_Device_Can_Be_Moved_To_Another_Location
	 * @param Device $Device 
	 */	
	public function test_Move_To_The_Same_Location_Does_Nothing(Device $Device)
	{
		$Device->move(new DeviceLocation('Another Location'));
		$this->assertDomainEventWasRecorded($Device, 'AppBundle\Domain\It\Device\Events\DeviceWasMoved');
		return $Device;
	}
	
	/**
	 * @depends test_Install_Device
	 * @param Device $Device 
	 */	
	public function test_Installed_Device_Can_Fail(Device $Device)
	{
		$Device->fail(new DeviceFailure('A fail', 'User', new \DateTimeImmutable()));
		$this->assertDomainEventWasRecorded($Device, 'AppBundle\Domain\It\Device\Events\DeviceFailed');
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
		$this->assertDomainEventWasRecorded($Device, 'AppBundle\Domain\It\Device\Events\DeviceWasSentToRepair');
		return $Device;
	}
	
	/**
	 * @depends test_Install_Device
	 * @expectedException OutOfBoundsException
	 * @param Device $Device 
	 */
	public function test_A_Device_That_Has_Not_Failed_Can_Not_Be_Sent_To_Repair(Device $Device)
	{
		$Device->sendToRepair(new DeviceFailure('A fail', 'User', new \DateTimeImmutable()), new DeviceTechnician('SAT'));
	}
	/**
	 * @depends test_Installed_Device_Can_Fail
	 * @param Device $Device 
	 */
	public function test_Device_Fix(Device $Device)
	{
		$Device->fix('Details');
		$this->assertDomainEventWasRecorded($Device, 'AppBundle\Domain\It\Device\Events\DeviceWasFixed');
		return $Device;
	}
	
	/**
	 * @depends test_Install_Device
	 * @expectedException OutOfBoundsException
	 * @param Device $Device 
	 */
	public function test_Do_Not_Fix_A_Device_that_do_not_need_to(Device $Device)
	{
		$Device->fix('Details');
	}

	/**
	 * @depends test_Install_Device
	 * @param Device $Device 
	 */
	public function test_Device_Retire(Device $Device)
	{
		$Device->retire('Reason');
		$this->assertDomainEventWasRecorded($Device, 'AppBundle\Domain\It\Device\Events\DeviceWasRetired');
	}
	/**
	 * @depends test_Install_Device
	 * @param Device $Device 
	 */

	public function test_Device_History(Device $Device)
	{
		$events = $Device->getRecordedEvents();
		$NewDevice = Device::reconstituteFrom($events);
		$this->assertTrue($Device->equals($NewDevice));
	}
}

?>