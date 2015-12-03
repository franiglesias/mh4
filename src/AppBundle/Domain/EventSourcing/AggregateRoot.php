<?php

namespace AppBundle\Domain\EventSourcing;

abstract class AggregateRoot implements RecordsEvents {
	private $events;
	
	protected function recordThat(DomainEvent $event)
	{
		$this->events[] = $event;
		$this->apply($event);
	}
	
	protected function apply(DomainEvent $event)
	{
		$method = 'apply'.substr(strrchr(get_class($event), '\\'), 1);;
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