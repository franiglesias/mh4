<?php

namespace AppBundle\Domain\It\Device\DeviceStates;

use AppBundle\Domain\It\Device\DeviceStates\AbstractDeviceState;
use AppBundle\Domain\It\Failure\Failure;

/**
* Devices uninstalled may be installed or repaired
*/
class ActiveDeviceState extends AbstractDeviceState
{

	public function repair(Failure $Failure, $technician)
	{
		$this->Device->setState(new RepairingDeviceState($this->Device));
	}
	
	public function retire($reason)
	{
		$this->Device->setState(new RetiredDeviceState($this->Device));
	}
	
	public function verbose()
	{
		return 'Device is installed and running.';
	}
}

?>