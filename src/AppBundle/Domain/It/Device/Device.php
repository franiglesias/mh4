<?php

namespace AppBundle\Domain\It\Device;

use AppBundle\Domain\It\Device\DeviceStates\UninstalledDeviceState;
use AppBundle\Domain\It\Failure\Failure;

use AppBundle\Domain\It\Device\ValueObjects\DeviceId;
use AppBundle\Domain\It\Device\ValueObjects\DeviceName;
use AppBundle\Domain\It\Device\ValueObjects\DeviceVendor;
use AppBundle\Domain\It\Device\ValueObjects\DeviceLocation;
use AppBundle\Domain\It\Device\ValueObjects\DeviceFailure;
use AppBundle\Domain\It\Device\ValueObjects\DeviceTechnician;

use AppBundle\Domain\EventSourcing\AggregateRoot;

use AppBundle\Domain\It\Device\Events\DeviceWasAcquired;
use AppBundle\Domain\It\Device\Events\DeviceWasInstalled;
use AppBundle\Domain\It\Device\Events\DeviceWasMoved;
use AppBundle\Domain\It\Device\Events\DeviceFailed;
use AppBundle\Domain\It\Device\Events\DeviceWasSentToRepair;
use AppBundle\Domain\It\Device\Events\DeviceWasFixed;
use AppBundle\Domain\It\Device\Events\DeviceWasRetired;
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
	private $available;
	
	private function __construct()
	{
		$this->state = new UninstalledDeviceState();
		$this->available = false;
	}
	
	static public function acquire(DeviceID $id, DeviceName $name, DeviceVendor $vendor)
	{
		$device = new self($id, $name, $vendor);
		$device->recordThat(new DeviceWasAcquired($id, $name, $vendor));
		return $device;
	}

	protected function applyDeviceWasAcquired(DeviceWasAcquired $event)
	{
		$this->id = $event->getAggregateId();
		$this->name = $event->getName();
		$this->vendor = $event->getVendor();
	}

	public function install(DeviceLocation $location)
	{
		$this->state = $this->state->install();
		$this->recordThat(new DeviceWasInstalled($this->id, $location));
	}
	
	protected function applyDeviceWasInstalled(DeviceWasInstalled $event)
	{
		$this->location = $event->getLocation();
		$this->available = true;
	}
	
	public function move(DeviceLocation $location)
	{
		if (!$this->location) {
			throw new \OutOfBoundsException('Device not installed');
		}
		if ($this->isSameLocation($location)) {
			return;
		}
		$this->recordThat(new DeviceWasMoved($this->id, $location));
	}
	
	protected function applyDeviceWasMoved(DeviceWasMoved $event)
	{
		$this->location = $event->getLocation();
		$this->available = true;
	}
	
	private function isSameLocation(DeviceLocation $location)
	{
		return $this->location->equals($location);
	}
	
	public function fail(DeviceFailure $Failure)
	{
		$this->state = $this->state->fail();
		$this->recordThat(new DeviceFailed($this->id, $Failure));
	}
	
	protected function applyDeviceFailed(DeviceFailed $event)
	{
		$this->available = false;
	}
	
	public function sendToRepair(DeviceFailure $failure, DeviceTechnician $technician)
	{
		$this->state = $this->state->sendToRepair();
		$this->recordThat(new DeviceWasSentToRepair($this->id, $failure, $technician));
	}
	
	protected function applyDeviceWasSentToRepair(DeviceWasSentToRepair $event)
	{
		$this->available = false;
	}

	public function fix()
	{
		$this->state = $this->state->fix();
		$this->recordThat(new DeviceWasFixed($this->id));
	}
	
	protected function applyDeviceWasFixed(DeviceWasFixed $event)
	{
		$this->available = true;
	}
	
	public function retire($reason)
	{
		$this->state = $this->state->retire();
		$this->recordThat(new DeviceWasRetired($this->id, $reason));
	}
	
	protected function applyDeviceWasRetired(DeviceWasRetired $evemt)
	{
		$this->available = false;
	}
}
?>