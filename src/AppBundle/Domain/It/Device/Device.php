<?php

namespace AppBundle\Domain\It\Device;

use AppBundle\Domain\It\Device\DeviceStates\UninstalledDeviceState;
use AppBundle\Domain\It\Failure\Failure;
use AppBundle\Domain\It\Device\ValueObjects\DeviceName;
use AppBundle\Domain\It\Device\ValueObjects\DeviceVendor;
use AppBundle\Domain\It\Device\ValueObjects\DeviceLocation;

/**
* Represents a Device.
* 
* A Device is any system used in the organization.
* Has identity given by his name
* Has lifecyle: acquired -> installed [-> Repaired ->Fixed]  -> Retired
*/
class Device
{
	private $name;
	private $vendor;
	private $state;
	private $location;
	private $Failures;
	
	private function __construct(DeviceName $name, DeviceVendor $vendor)
	{
		$this->name = $name;
		$this->vendor = $vendor;
		$this->state = new UninstalledDeviceState();
	}
	
	static public function register(DeviceName $name, DeviceVendor $vendor)
	{
		return new self($name, $vendor);
	}
	
	public function install(DeviceLocation $location)
	{
		$this->state = $this->state->install();
		$this->location = $location;
	}
	
	public function fail(Failure $Failure)
	{
		$this->state = $this->state->fail();
		$this->Failures[] = $Failure;
	}
	
	public function sendToRepair()
	{
		$this->state = $this->state->sendToRepair();
	}
	
	public function where()
	{
		return $this->location;
	}
	
	public function moveTo(DeviceLocation $location)
	{
		$this->location = $location;
	}
	
	public function getFailures()
	{
		return $this->Failures;
	}
}
?>