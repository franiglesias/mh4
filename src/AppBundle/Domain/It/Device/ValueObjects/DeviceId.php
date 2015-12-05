<?php
namespace AppBundle\Domain\It\Device\ValueObjects;

use Ramsey\Uuid\Uuid;
/**
* Value Object to Represent Identity of Device Entities
*/
class DeviceID
{
	private $id;
	
	function __construct($id = false)
	{
		if (!$id) {
			$this->id = Uuid::uuid4()->toString();
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