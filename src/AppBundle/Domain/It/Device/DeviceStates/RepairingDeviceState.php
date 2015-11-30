<?php

namespace AppBundle\Domain\It\Device\DeviceStates;

/**
* Devices sent to sendToRepair may be fixed or retired
*/
class RepairingDeviceState extends AbstractDeviceState
{

	public function fix()
	{
		return new ActiveDeviceState();
	}
	
	public function retire()
	{
		return new RetiredDeviceState();
	}
	
	public function verbose()
	{
		return 'Device is being sendToRepaired.';
	}
}

?>