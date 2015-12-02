<?php

namespace AppBundle\Domain\It\Device\ValueObjects;

/**
* Holds installation information
*/
class DeviceLocation
{
	private $location;
	
	function __construct($location)
	{
		if (empty($location)) {
			throw new \InvalidArgumentException('Provide a Location to install a Device.');
		}
		$this->location = $location;
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