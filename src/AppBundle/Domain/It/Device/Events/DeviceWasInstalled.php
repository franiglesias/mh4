<?php

namespace AppBundle\Domain\It\Device\Events;

use AppBundle\Domain\It\Device\ValueObjects\DeviceId;
use AppBundle\Domain\It\Device\ValueObjects\DeviceLocation;

class DeviceWasInstalled
{
	private $aggregate_id;
	private $location;
	
	function __construct(DeviceId $id, DeviceLocation $location)
	{
		$this->aggregate_id = $id;
		$this->location = $location;
	}
	
	public function getAggregateId()
	{
		return $this->aggregate_id;
	}
	
	public function getLocation()
	{
		return $this->location;
	}
	
	
	public function getEvent()
	{
		return 'DeviceWasInstalled';
	}
}

?>