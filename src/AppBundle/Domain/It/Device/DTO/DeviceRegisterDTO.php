<?php

namespace AppBundle\Domain\It\Device\DTO;

/**
* Carries Data to Register a Device
*/
class DeviceRegisterDTO
{
	private $name;
	private $vendor;
	private $model;
	private $serial;
	
	function __construct($name, $vendor, $model, $serial)
	{
		$this->name = $name;
		$this->vendor = $vendor;
		$this->model = $model;
		$this->serial = $serial;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getVendor()
	{
		return $this->vendor;
	}
	
	public function getModel()
	{
		return $this->model;
	}
	
	public function getSerial()
	{
		return $this->serial;
	}
	
}
?>