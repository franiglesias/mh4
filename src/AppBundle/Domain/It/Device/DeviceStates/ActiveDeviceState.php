<?php

namespace AppBundle\Domain\It\Device\DeviceStates;

/**
 * Active Devices may be sent to sendToRepair or retired
 *
 * @package default
 * @author Fran Iglesias
 */
class ActiveDeviceState extends AbstractDeviceState
{

	public function fail()
	{
		return new FailedDeviceState();
	}
	
	public function retire()
	{
		return new RetiredDeviceState();
	}
	
	public function verbose()
	{
		return 'Device is installed and running.';
	}
}

?>