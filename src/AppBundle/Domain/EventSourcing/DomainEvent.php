<?php

namespace AppBundle\Domain\EventSourcing;

interface DomainEvent {
	public function getAggregateId();
}

?>