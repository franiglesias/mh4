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
		$this->name = $this->validName($name);
	}
	
	private function validName($name)
	{
		if (empty($name)) {
			throw new \InvalidArgumentException('Provide a Name to install a Device.');
		}
		return $name;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
}
?>