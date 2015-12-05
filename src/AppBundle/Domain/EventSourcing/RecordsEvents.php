<?php

namespace AppBundle\Domain\EventSourcing;

/**
 * Represents the ability of an aggregate to provide a list of recent events
 *
 * @package default
 * @author Francisco Iglesias Gómez
 */
interface RecordsEvents {
	/**
	 * A collection of recent events recorded by the Aggregator
	 *
	 * @return AggregateHistoryInterface
	 * @author Francisco Iglesias Gómez
	 */
	public function getRecordedEvents();
	public function cleanRecordedEvents();
}

?>