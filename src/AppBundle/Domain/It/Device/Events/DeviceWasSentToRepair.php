<?php

namespace AppBundle\Domain\It\Device\Events;

use AppBundle\Domain\EventSourcing\DomainEvent;
use AppBundle\Domain\It\Device\ValueObjects\DeviceId;
use AppBundle\Domain\It\Device\ValueObjects\DeviceFailure;
use AppBundle\Domain\It\Device\ValueObjects\DeviceTechnician;

class DeviceWasSentToRepair implements DomainEvent
{
	private $aggregate_id;
	private $failure;
	private $technician;
	
	function __construct(DeviceId $id, DeviceFailure $failure, DeviceTechnician $technician)
	{
		$this->aggregate_id = $id;
		$this->failure = $failure;
		$this->technician = $technician;
	}
	
	public function getAggregateId()
	{
		return $this->aggregate_id;
	}
	
	public function getFailure()
	{
		return $this->failure;
	}
	
	public function getTechnician()
	{
		return $this->technician;
	}
	
	public function getEvent()
	{
		return 'DeviceWasSentToRepair';
	}
}

?>