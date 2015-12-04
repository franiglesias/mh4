<?php

namespace AppBundle\Tests\Domain\EventSourcing;

use AppBundle\Domain\EventSourcing\AggregateRoot;
use AppBundle\Domain\EventSourcing\DomainEvent;

class Aggregate extends AggregateRoot {
	private $id;
	private $state;
	private $lastMessage;
	
	public function __construct()
	{
		$this->state = 0;
		$this->lastMessage = '';
	}
	
	static function reconstituteFrom($events)
	{
		$aggregate = new self();
		foreach ($events as $event) {
			$aggregate->apply($event);
		}
		return $aggregate;
	}
	
	public function doSomething($message)
	{
		$this->recordThat(new EventHappened($this->id, $message));
	}
	
	protected function applyEventHappened(EventHappened $event)
	{
		$this->lastMessage = $event->getArgument();
		++$this->state;
	}
	
	public function getState()
	{
		return $this->lastMessage;
	}
}

class EventHappened implements DomainEvent {
	
	private $aggregate_id;
	private $argument;
	
	public function __construct($aggregate_id, $argument)
	{
		$this->aggregate_id = $aggregate_id;
		$this->argument = $argument;
	}
	public function getAggregateId()
	{
		return $this->aggregate_id;
	}
	
	public function getArgument()
	{
		return $this->argument;
	}
	
	public function getName()
	{
		return 'EventHappened';
	}
}

class AggregateRootTests extends \PHPUnit_Framework_Testcase {
	
	public function testAggregate()
	{
		$A = new Aggregate();
		$this->assertInstanceOf('AppBundle\Domain\EventSourcing\AggregateRoot', $A);
	}
	
	public function testAggregateRecordsEvents()
	{
		$A = new Aggregate();
		$A->doSomething('Hello');
		$this->assertEquals(1, count($A->getRecordedEvents()));
		$this->assertEquals('Hello', $A->getState());
		$A->doSomething('Hello again');
		$this->assertEquals(2, count($A->getRecordedEvents()));
		$this->assertEquals('Hello again', $A->getState());
		
	}
	
	public function testWeCanReconstituteAnAggregateFromEventsStory()
	{
		$A = new Aggregate();
		$A->doSomething('Hello');
		$A->doSomething('Hello again');
		
		$B = Aggregate::reconstituteFrom($A->getRecordedEvents());
		$this->assertEquals(0, count($B->getRecordedEvents()));
		$this->assertEquals('Hello again', $B->getState());
	}
	
}

?>