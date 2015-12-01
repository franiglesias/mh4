<?php

namespace AppBundle\Domain\It\Device\ValueObjects;

/**
* Value Object to Represent Vendor Information for a Device
*/
class VendorInformation
{
	private $vendor;
	private $model;
	private $serial;
	
	function __construct($vendor, $model, $serial = 'N/A')
	{
		$this->vendor = $vendor;
		$this->model = $model;
		$this->serial = $serial;
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