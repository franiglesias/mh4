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
	
	public function getInMemoryRepository()
	{
		return new InMemoryDeviceRepository(
			new InMemoryEventSourcingRepository(
				new TraceableEventStore(new InMemoryEventStore()), 
				new SimpleEventBus(), 
				'AppBundle\Domain\It\Device\Device', 
				new NamedConstructorAggregateFactory('reconstitute')
			)
		);
	}
}

?>