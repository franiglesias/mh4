<?php
namespace AppBundle\Domain\It\Device\ValueObjects;

use Broadway\UuidGenerator\Rfc4122\Version4Generator;
/**
* Value Object to Represent Identity of Device Entities
*/
class DeviceId
{
	private $id;
	
	function __construct($id = false)
	{
		if (!$id) {
			$this->id = (new Version4Generator())->generate();
		} else {
			
		$this->id = $id;
		}
	}
	
	public function getValue()
	{
		return $this->id;
	}
	
	public function equals(DeviceId $id)
	{
		return $this->id == $id->getValue();
	}
}
?>