<?php

namespace AppBundle\Infrastructure\Persistence;

use AppBundle\Domain\It\Device\DeviceRepositoryInterface;
use AppBundle\Domain\It\Device\ValueObjects\DeviceId;
use AppBundle\Domain\It\Device\Device;
use AppBundle\Infrastructure\Persistence\InMemoryEventSourcingRepository;


class InMemoryDeviceRepository implements DeviceRepositoryInterface {
	
	private $devices;
	private $EventSourcingRepository;
	
	public function __construct(InMemoryEventSourcingRepository $EventSourcingRepository)
	{
		$this->EventSourcingRepository = $EventSourcingRepository;
	}
	
	public function load(DeviceId $id)
	{
		return $this->EventSourcingRepository->load($id->getValue());
	}
	
	public function save(Device $Device)
	{
		$this->EventSourcingRepository->save($Device);
	}
	
	public function count()
	{
		return count($this->devices);
	}
}

// class InvitationRepository
// {
//     public function __construct(Broadway\EventStore\EventStoreInterface $eventStore, Broadway\EventHandling\EventBusInterface $eventBus)
//     {
//         parent::__construct($eventStore, $eventBus, 'Invitation', new Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory());
//     }
// }


?>