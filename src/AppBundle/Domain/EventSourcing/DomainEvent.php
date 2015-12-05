<?php

namespace AppBundle\Domain\EventSourcing;

/**
 * Represents something important happended in the Domain;
 * In practice is a Data Transport Object. Describes the event that happened and contains the data needed to replay it
 * @package default
 * @author Francisco Iglesias Gómez
 */
interface DomainEvent {
	public function getAggregateId();
	public function getEvent();
}

?>