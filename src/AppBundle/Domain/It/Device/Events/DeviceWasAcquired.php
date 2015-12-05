<?php

namespace AppBundle\Domain\It\Device\Events;

use AppBundle\Domain\EventSourcing\DomainEvent;
use AppBundle\Domain\It\Device\ValueObjects\DeviceId;
use AppBundle\Domain\It\Device\ValueObjects\DeviceName;
use AppBundle\Domain\It\Device\ValueObjects\DeviceVendor;

class DeviceWasAcquired implements DomainEvent
{
	private $aggregate_id;
	private $name;
	private $vendor;
	
	function __construct(DeviceId $id, DeviceName $name, DeviceVendor $vendor)
	{
		$this->aggregate_id = $id;
		$this->name = $name;
		$this->vendor = $vendor;
	}
	
	public function getAggregateId()
	{
		return $this->aggregate_id;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getVendor()
	{
		return $this->vendor;
	}
	
	public function getEvent()
	{
		return 'DeviceWasAcquired';
	}
}

?>