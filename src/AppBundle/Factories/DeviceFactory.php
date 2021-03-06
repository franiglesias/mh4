<?php

namespace AppBundle\Factories;

use Broadway\EventHandling\EventBusInterface;
use Broadway\EventHandling\SimpleEventBus;
use Broadway\EventStore\EventStoreInterface;
use Broadway\EventStore\InMemoryEventStore;
use Broadway\EventStore\TraceableEventStore;

use Broadway\EventSourcing\AggregateFactory\NamedConstructorAggregateFactory;
use AppBundle\Infrastructure\Persistence\InMemoryEventSourcingRepository;
use AppBundle\Infrastructure\Persistence\InMemoryDeviceRepository;

class DeviceFactory {
	
	public function getInMemoryRepository(\Broadway\EventStore\EventStoreInterface $eventStore, \Broadway\EventHandling\EventBusInterface $eventBus)
	{
		return new InMemoryDeviceRepository(
			new InMemoryEventSourcingRepository(
				$eventStore, 
				$eventBus, 
				'AppBundle\Domain\It\Device\Device', 
				new NamedConstructorAggregateFactory('reconstitute')
			)
		);
	}
}

?>