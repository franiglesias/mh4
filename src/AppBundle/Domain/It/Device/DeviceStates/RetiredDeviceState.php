<?php

namespace AppBundle\Domain\It\Device\DeviceStates;

/**
* You can do nothing with retired devices
*/
class RetiredDeviceState extends AbstractDeviceState
{

	public function verbose()
	{
		return 'Device was retired.';
	}
}

?>