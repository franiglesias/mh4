<?php

namespace AppBundle\Domain\It\Device\Commands;

use AppBundle\Domain\It\Device\ValueObjects as VO;

class InstallDevice {
	private $deviceId;
	private $location;
	
	public function __construct(VO\DeviceId $deviceId, VO\DeviceLocation $location)
	{
		$this->deviceId = $deviceId;
		$this->location = $location;
	}
	
	public function getDeviceId()
	{
		return $this->deviceId;
	}
	
	public function getLocation()
	{
		return $this->location;
	}
	
}
?>