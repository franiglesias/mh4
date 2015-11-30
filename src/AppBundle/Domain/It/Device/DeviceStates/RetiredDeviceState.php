<?php

namespace AppBundle\Domain\It\Device\DeviceStates;

use AppBundle\Domain\It\Device\DeviceStates\AbstractDeviceState;

/**
* Devices uninstalled may be installed or repaired
*/
class RetiredDeviceState extends AbstractDeviceState
{

	public function verbose()
	{
		return 'Device was retired.';
	}
}

?>