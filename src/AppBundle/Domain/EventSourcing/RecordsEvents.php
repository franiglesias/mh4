<?php

namespace AppBundle\Domain\EventSourcing;

interface RecordsEvents {
	public function getRecordedEvents();
	public function cleanRecordedEvents();
}

?>