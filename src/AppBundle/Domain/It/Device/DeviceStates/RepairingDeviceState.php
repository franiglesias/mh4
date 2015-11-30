<?php

namespace AppBundle\Domain\It\Device\DeviceStates;

use AppBundle\Domain\It\Device\DeviceStates\AbstractDeviceState;

/**
* Devices uninstalled may be installed or repaired
*/
class RepairingDeviceState extends AbstractDeviceState
{

	public function fix()
	{
		$this->Device->setState(new ActiveDeviceState($this->Device));
	}
	
	public function retire($reason)
	{
		$this->Device->setState(new RetiredDeviceState($this->Device));
	}
	
	public function verbose()
	{
		return 'Device is being repaired.';
	}
}

?>