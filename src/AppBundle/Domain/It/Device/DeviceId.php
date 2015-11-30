<?php
namespace AppBundle\Domain\It\Device;

/**
* Value Object to Represent Identity of Device Entities
*/
class DeviceID
{
	private $id;
	
	function __construct($id)
	{
		$this->id = $id;
	}
	
	public function getValue()
	{
		return $this->id;
	}
	
	public function equals(DeviceId $id)
	{
		return $this->id = $id->getValue();
	}
}
?>