<?php

namespace AppBundle\Domain\It\Device\DeviceStates;

/**
* Devices uninstalled can be installed
*/
class UninstalledDeviceState extends AbstractDeviceState
{

	public function install()
	{
		return new ActiveDeviceState();
	}
	
	public function verbose()
	{
		return 'Device is uninstalled.';
	}
}

?>