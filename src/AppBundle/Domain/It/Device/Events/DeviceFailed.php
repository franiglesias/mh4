<?php

namespace AppBundle\Domain\It\Device\Events;

use AppBundle\Domain\It\Device\ValueObjects\DeviceId;
use AppBundle\Domain\It\Device\ValueObjects\DeviceFailure;

class DeviceFailed
{
	private $aggregate_id;
	private $failure;
	
	function __construct(DeviceId $id, DeviceFailure $location)
	{
		$this->aggregate_id = $id;
		$this->location = $location;
	}
	
	public function getAggregateId()
	{
		return $this->aggregate_id;
	}
	
	public function getFailure()
	{
		return $this->failure;
	}
	
	
	public function getEvent()
	{
		return 'DeviceFailed';
	}
}

?>