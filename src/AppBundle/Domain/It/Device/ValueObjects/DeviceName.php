<?php

namespace AppBundle\Domain\It\Device\ValueObjects;

/**
* Holds installation information
*/
class DeviceName
{
	private $name;
	
	function __construct($name)
	{
		if (empty($name)) {
			throw new \InvalidArgumentException('Provide a Name to install a Device.');
		}
		$this->name = $name;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
}
?>