<?php

namespace AppBundle\Domain\EventSourcing;

abstract class AggregateRoot implements RecordsEvents {
	/**
	 * Store latest events
	 *
	 * @var array
	 */
	private $events;
	
	/**
	 * Register and apply an event
	 *
	 * @param DomainEvent $event 
	 * @return void
	 * @author Fran Iglesias
	 */
	protected function recordThat(DomainEvent $event)
	{
		$this->events[] = $event;
		$this->apply($event);
	}

	/**
	 * Executes the method that handles the event in the aggregate
	 *
	 * @param DomainEvent $event 
	 * @return void
	 * @author Fran Iglesias
	 */
	protected function apply(DomainEvent $event)
	{
		$method = 'apply'.$event->getName();
		if (!method_exists($this, $method)) {
			throw new \BadMethodCallException($method.' not found.');
		}
		$this->$method($event);
	}
	
	public function getRecordedEvents() {
		return $this->events;
	}
	
	public function cleanRecordedEvents() {
		$this->events = array();
	}
}
?>