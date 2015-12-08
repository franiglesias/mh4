<?php

namespace AppBundle\Domain\It\Device\Events;

use AppBundle\Domain\EventSourcing\DomainEvent;
use AppBundle\Domain\It\Device\ValueObjects\DeviceId;
use AppBundle\Domain\It\Device\ValueObjects\DeviceFailure;

class DeviceWasFixed implements DomainEvent
{
	private $aggregate_id;
	private $details;
	
	function __construct(DeviceId $id, $details)
	{
		$this->aggregate_id = $id;
	}
	
	public function getAggregateId()
	{
		return $this->aggregate_id;
	}
	
	public function getDetails()
	{
		return $this->details;
	}
	
	public function getEvent()
	{
		return 'DeviceWasFixed';
	}
}

?>