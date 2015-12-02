<?php

namespace AppBundle\Domain\It\Device\ValueObjects;

/**
* Value Object to Represent Vendor Information for a Device
*/
class DeviceVendor
{
	private $vendor;
	private $model;
	private $serial;
	
	function __construct($vendor, $model, $serial = 'N/A')
	{
		$this->vendor = $this->validVendor($vendor);
		$this->model = $this->validModel($model);
		$this->serial = $serial;
	}
	
	private function validVendor($vendor)
	{
		if (empty($vendor)) {
			throw new \InvalidArgumentException('Vendor should not empty');
		}
		return $vendor;
	}
	
	public function validModel($model)
	{
		if (empty($model)) {
			throw new \InvalidArgumentException('Model should not be empty');
		}
		return $model;
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
		return $this->serial();
	}
}
?>