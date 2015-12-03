<?php

namespace AppBundle\Tests\Domain\EventSourcing;

use AppBundle\Domain\EventSourcing\AggregateRoot;
use AppBundle\Domain\EventSourcing\DomainEvent;

class Aggregate extends AggregateRoot {
	private $id;
	private $state;
	
	public function __construct()
	{
		$this->state = 0;
	}
	
	static function reconstituteFrom($events)
	{
		$aggregate = new self();
		foreach ($events as $event) {
			$aggregate->recordThat($event);
		}
		return $aggregate;
	}
	
	public function doSomething()
	{
		$this->recordThat(new EventHappened($this->id));
	}
	
	protected function applyEventHappened(EventHappened $event)
	{
		++$this->state;
	}
	
	public function getState()
	{
		return $this->state;
	}
}

class EventHappened implements DomainEvent {
	
	private $aggregate_id;
	
	public function __construct($aggregate_id)
	{
		$this->aggregate_id = $aggregate_id;
	}
	public function getAggregateId()
	{
		return $this->aggregate_id;
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
		$A->doSomething();
		$this->assertEquals(1, count($A->getRecordedEvents()));
		
		$A->doSomething();
		$this->assertEquals(2, count($A->getRecordedEvents()));
		
		$this->assertEquals(2, $A->getState());
	}
	
	public function testWeCanReconstuteAnAggregateFromEventsStory()
	{
		$A = new Aggregate();
		$A->doSomething();
		$A->doSomething();
		
		$B = Aggregate::reconstituteFrom($A->getRecordedEvents());
		$this->assertEquals(2, $B->getState());
		$this->assertEquals(2, count($B->getRecordedEvents()));
		
		$this->assertEquals($B, $A);
	}
	
}

?>