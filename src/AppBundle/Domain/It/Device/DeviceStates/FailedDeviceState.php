<?php

namespace AppBundle\Domain\It\Device\DeviceStates;

/**
 * Failed Devices can be sent to retire or retire
 *
 * @package default
 * @author Fran Iglesias
 */
class FailedDeviceState extends AbstractDeviceState
{

	public function sendToRepair()
	{
		return new RepairingDeviceState();
	}
	
	public function retire()
	{
		return new RetiredDeviceState();
	}
	
	public function verbose()
	{
		return 'Device has failed and is waiting for repair.';
	}
}

?>