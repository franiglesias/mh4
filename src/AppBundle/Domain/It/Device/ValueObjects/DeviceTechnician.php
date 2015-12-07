<?php

namespace AppBundle\Domain\It\Device\ValueObjects;

/**
* Holds installation information
*/
class DeviceTechnician
{
	private $technician;
	
	function __construct($technician)
	{
		if (empty($technician)) {
			throw new \InvalidArgumentException('Provide a Technician to install a Device.');
		}
		$this->technician = $technician;
	}
	
	public function getTechnician()
	{
		return $this->technician;
	}
	
	public function equals($technician)
	{
		return strtolower($this->technician) == strtolower($technician->getTechnician());
	}
	
}
?>