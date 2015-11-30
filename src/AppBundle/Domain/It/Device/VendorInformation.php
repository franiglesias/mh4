<?php

namespace AppBundle\Domain\It\Device;

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
}
?>