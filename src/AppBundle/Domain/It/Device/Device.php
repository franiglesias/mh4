<?php

namespace AppBundle\Domain\It\Device;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Broadway\Domain\DomainEventStreamInterface;

use AppBundle\Domain\It\Device\DeviceStates as States;
use AppBundle\Domain\It\Device\ValueObjects as VO;
use AppBundle\Domain\It\Device\Events as Events;

/**
* Represents a Device.
* 
* A Device is any system used in the organization.
* Has identity given by his name
* Has lifecyle: acquired -> installed [-> Repaired ->Fixed]  -> Retired
*/
class Device extends EventSourcedAggregateRoot
{
	private $id;
	private $name;
	private $vendor;
	private $state;
	private $location;
	private $available;
	
	private function __construct()
	{
		$this->state = new States\UninstalledDeviceState();
	}
	
	public function getAggregateRootId()
	{
		return $this->id->getValue();
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	static public function acquire(VO\DeviceId $id, VO\DeviceName $name, VO\DeviceVendor $vendor)
	{
		$device = new self();
		$device->apply(new Events\DeviceWasAcquired($id, $name, $vendor));
		return $device;
	}
	
	static public function reconstitute()
	{
		$device = new self();
		return $device;
	}
	
	public function equals(Device $Device)
	{
		return (
			$this->id == $Device->id &&
			$this->name == $Device->name &&
			$this->state == $Device->state &&
			$this->location == $Device->location &&
			$this->available == $Device->available
		);
	}

	protected function applyDeviceWasAcquired(Events\DeviceWasAcquired $event)
	{
		$this->id = $event->getAggregateId();
		$this->name = $event->getName();
		$this->vendor = $event->getVendor();
		$this->available = false;
		$this->state = new States\UninstalledDeviceState();
	}

	public function install(VO\DeviceLocation $location)
	{
		$this->state = $this->state->install();
		$this->apply(new Events\DeviceWasInstalled($this->id, $location));
	}
	
	protected function applyDeviceWasInstalled(Events\DeviceWasInstalled $event)
	{
		$this->location = $event->getLocation();
		$this->available = true;
		$this->state = new States\ActiveDeviceState();
	}
	
	public function move(VO\DeviceLocation $location)
	{
		if (!$this->location) {
			throw new \UnderflowException('Device not installed');
		}
		if ($this->isSameLocation($location)) {
			return;
		}
		$this->apply(new Events\DeviceWasMoved($this->id, $location));
	}
	
	protected function applyDeviceWasMoved(Events\DeviceWasMoved $event)
	{
		$this->location = $event->getLocation();
		$this->available = true;
	}
	
	private function isSameLocation(VO\DeviceLocation $location)
	{
		return $this->location->equals($location);
	}
	
	public function fail(VO\DeviceFailure $Failure)
	{
		$this->state = $this->state->fail();
		$this->apply(new Events\DeviceFailed($this->id, $Failure));
		
	}
	
	protected function applyDeviceFailed(Events\DeviceFailed $event)
	{
		$this->available = false;
		$this->state = new States\FailedDeviceState();
	}
	
	public function sendToRepair(VO\DeviceFailure $failure, VO\DeviceTechnician $technician)
	{
		$this->state = $this->state->sendToRepair();
		$this->apply(new Events\DeviceWasSentToRepair($this->id, $failure, $technician));
	}
	
	protected function applyDeviceWasSentToRepair(Events\DeviceWasSentToRepair $event)
	{
		$this->available = false;
		$this->state = new States\RepairingDeviceState();
	}

	public function fix($details)
	{
		$this->state = $this->state->fix();
		$this->apply(new Events\DeviceWasFixed($this->id, $details));
	}
	
	protected function applyDeviceWasFixed(Events\DeviceWasFixed $event)
	{
		$this->available = true;
		$this->state = new States\ActiveDeviceState();
	}
	
	public function retire($reason)
	{
		$this->state = $this->state->retire();
		$this->apply(new Events\DeviceWasRetired($this->id, $reason));
	}
	
	protected function applyDeviceWasRetired(Events\DeviceWasRetired $evemt)
	{
		$this->available = false;
		$this->state = new States\RetiredDeviceState();
	}
}
?>