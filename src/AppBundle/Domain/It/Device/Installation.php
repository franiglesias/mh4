<?php

namespace AppBundle\Domain\It\Device;

/**
* Holds installation information
*/
class Installation
{
	private $location;
	private $date;
	
	function __construct($location, \DateTimeImmutable $date)
	{
		$this->location = $location;
		$this->date = $date;
	}
	
	public function getLocation()
	{
		return $this->location;
	}
	
	public function getDate()
	{
		return $this->date;
	}
}
?>