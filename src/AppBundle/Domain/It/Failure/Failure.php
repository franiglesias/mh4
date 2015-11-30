<?php

namespace AppBundle\Domain\It\Failure;

/**
* Represents the Failure of a Device
*/
class Failure
{
	private $description;
	private $reportDate;
	private $fixDate;
	private $assignedTo;
	private $state;
	
	function __construct($description, $technician)
	{
		$this->description = $description;
		$this->reportDate = new \DateTimeImmutable();
		$this->fixDate = null;
		$this->assignedTo = $technician;
	}
}

?>