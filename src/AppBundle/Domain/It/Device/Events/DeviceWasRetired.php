<?php

namespace AppBundle\Domain\It\Device\Events;

use AppBundle\Domain\EventSourcing\DomainEvent;
use AppBundle\Domain\It\Device\ValueObjects\DeviceId;
use AppBundle\Domain\It\Device\ValueObjects\DeviceLocation;

class DeviceWasRetired implements DomainEvent
{
	private $aggregate_id;
	private $reason;
	
	function __construct(DeviceId $id, $reason)
	{
		$this->aggregate_id = $id;
		$this->reason = $reason;
	}
	
	public function getAggregateId()
	{
		return $this->aggregate_id;
	}
	
	public function getLocation()
	{
		return $this->reason;
	}
	
	
	public function getEvent()
	{
		return 'DeviceWasRetired';
	}
}

?>