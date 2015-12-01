<?php

namespace AppBundle\Domain\It\Device;

use AppBundle\Domain\It\Device\DeviceStates\UninstalledDeviceState;
use AppBundle\Domain\It\Failure\Failure;
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
	private $installation;
	private $Failures;
	
	public function __construct($name, $vendor)
	{
		$this->name = $name;
		$this->vendor = $vendor;
		$this->state = new UninstalledDeviceState();
	}
	
	public function install(Installation $installation)
	{
		$this->state = $this->state->install();
		$this->installation = $installation;
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
		return $this->installation;
	}
	
	public function moveTo(Installation $installation)
	{
		$this->installation = $installation;
	}
	
	public function getFailures()
	{
		return $this->Failures;
	}
}
?>