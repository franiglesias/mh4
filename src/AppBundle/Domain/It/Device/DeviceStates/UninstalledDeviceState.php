<?php

namespace AppBundle\Domain\It\Device\DeviceStates;

use AppBundle\Domain\It\Device\DeviceStates\AbstractDeviceState;

/**
* Devices uninstalled may be installed or repaired
*/
class UninstalledDeviceState extends AbstractDeviceState
{

	public function install($location, \DateTimeImmutable $date)
	{
		$this->Device->setState(new ActiveDeviceState($this->Device));
	}
	
	public function verbose()
	{
		return 'Device is uninstalled.';
	}
}

?>