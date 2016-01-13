<?php

namespace AppBundle\Domain\It\Device\Commands;

use AppBundle\Domain\It\Device\ValueObjects as VO;

class RetireDevice {
	private $deviceId;
	private $reason;
	
	public function __construct(VO\DeviceId $deviceId, $reason)
	{
		$this->deviceId = $deviceId;
		$this->reason = $reason;
	}
	
	public function getDeviceId()
	{
		return $this->deviceId;
	}
	
	public function getReason()
	{
		return $this->reason;
	}
	
}
?>