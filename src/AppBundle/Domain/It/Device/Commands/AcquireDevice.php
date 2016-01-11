<?php

namespace AppBundle\Domain\It\Device\Commands;

use AppBundle\Domain\It\Device\ValueObjects as VO;

class AcquireDevice {
	private $deviceId;
	private $name;
	private $vendor;
	
	public function __construct(VO\DeviceId $deviceId, VO\DeviceName $name, VO\DeviceVendor $vendor)
	{
		$this->deviceId = $deviceId;
		$this->name = $name;
		$this->vendor = $vendor;
	}
	
	public function getDeviceId()
	{
		return $this->deviceId;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getVendor()
	{
		return $this->vendor;
	}
}
?>