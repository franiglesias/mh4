<?php

namespace AppBundle\Domain\EventSourcing;
/**
 * Represents a collecton of events related to an aggregate
 * It could be the complete aggregate history or list of recen events
 * @package default
 * @author Francisco Iglesias Gómez
 */
interface AggregateHistoryInterface {
	private $aggregate_id;
	private $events;
	
	public function getAggregateId();
	public function recordEvent(DomainEvent $event);
	public function getEvents();
	public function getLastEvent();
	public function flush();
}

?>