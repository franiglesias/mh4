<?php

namespace AppBundle\Domain\It\Device\ValueObjects;

/**
* Holds installation information
*/
class Installation
{
	private $location;
	private $date;
	
	function __construct($location, \DateTimeImmutable $date)
	{
		if (empty($location)) {
			throw new \InvalidArgumentException('Provide a Location to install a Device.');
		}
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