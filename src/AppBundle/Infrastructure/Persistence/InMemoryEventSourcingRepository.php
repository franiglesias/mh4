<?php

namespace AppBundle\Infrastructure\Persistence;


class InMemoryEventSourcingRepository extends \Broadway\EventSourcing\EventSourcingRepository 
{
    public function __construct(\Broadway\EventStore\EventStoreInterface $eventStore, \Broadway\EventHandling\EventBusInterface $eventBus, $aggregate, $factory)
    {
        parent::__construct($eventStore, $eventBus, $aggregate, $factory);
    }
}

?>