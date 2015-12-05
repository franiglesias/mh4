<?php

namespace AppBundle\Domain\It\Device;

use AppBundle\Domain\It\Device\DeviceStates\UninstalledDeviceState;
use AppBundle\Domain\It\Failure\Failure;
use AppBundle\Domain\It\Device\ValueObjects\DeviceId;
use AppBundle\Domain\It\Device\ValueObjects\DeviceName;
use AppBundle\Domain\It\Device\ValueObjects\DeviceVendor;
use AppBundle\Domain\It\Device\ValueObjects\DeviceLocation;
use AppBundle\Domain\EventSourcing\AggregateRoot;
use AppBundle\Domain\It\Device\Events\DeviceWasAcquired;
use AppBundle\Domain\It\Device\Events\DeviceWasInstalled;
use AppBundle\Domain\It\Device\Events\DeviceWasMoved;
/**
* Represents a Device.
* 
* A Device is any system used in the organization.
* Has identity given by his name
* Has lifecyle: acquired -> installed [-> Repaired ->Fixed]  -> Retired
*/
class Device extends AggregateRoot
{
	private $id;
	private $name;
	private $vendor;
	private $state;
	private $location;
	
	private function __construct()
	{
		$this->state = new UninstalledDeviceState();
	}
	
	static public function acquire(DeviceID $id, DeviceName $name, DeviceVendor $vendor)
	{
		$device = new self($id, $name, $vendor);
		$device->recordThat(new DeviceWasAcquired($id, $name, $vendor));
		return $device;
	}

	public function install(DeviceLocation $location)
	{
		$this->state = $this->state->install();
		$this->recordThat(new DeviceWasInstalled($this->id, $location));
	}
	
	public function move(DeviceLocation $location)
	{
		if ($this->isSameLocation($location)) {
			return;
		}
		$this->recordThat(new DeviceWasMoved($this->id, $location));
	}
	
	private function isSameLocation(DeviceLocation $location)
	{
		return $this->location->equals($location);
	}
	protected function applyDeviceWasAcquired(DeviceWasAcquired $event)
	{
		$this->id = $event->getAggregateId();
		$this->name = $event->getName();
		$this->vendor = $event->getVendor();
	}
	
	protected function applyDeviceWasInstalled(DeviceWasInstalled $event)
	{
		$this->location = $event->getLocation();
	}
	
	protected function applyDeviceWasMoved(DeviceWasMoved $event)
	{
		$this->location = $event->getLocation();
	}
	//
	// public function fail(Failure $Failure)
	// {
	// 	$this->state = $this->state->fail();
	// 	$this->Failures[] = $Failure;
	// }
	//
	// public function sendToRepair()
	// {
	// 	$this->state = $this->state->sendToRepair();
	// }
	//
	// public function whereIs()
	// {
	// 	return $this->location;
	// }
	//
	// public function moveTo(DeviceLocation $location)
	// {
	// 	$this->location = $location;
	// }
	//
	// public function getFailures()
	// {
	// 	return $this->Failures;
	// }
}
?>