<?php

namespace AppBundle\Domain\EventSourcing;
/**
 * Represents a mechanism for events to persist.
 * Could be implemented to support different stores
 * @package default
 * @author Francisco Iglesias Gómez
 */
interface EventRepositoryInterface {
	public function fetchFor(AggregateRootID $AggregateRoot_id);
	public function store(AggregateHistory $events);
}

?>