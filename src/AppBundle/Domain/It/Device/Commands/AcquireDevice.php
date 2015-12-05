<?php

namespace AppBundle\Domain\It\Device\Commands;

class AcquireDevice {
	private $deviceId;
	private $name;
	private $vendor;
	
	public function __construct(DeviceID $deviceId, DeviceName $name, DeviceVendor $vendor)
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