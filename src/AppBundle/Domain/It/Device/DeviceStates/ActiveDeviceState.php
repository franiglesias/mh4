<?php

namespace AppBundle\Domain\It\Device\DeviceStates;

/**
 * Active Devices may be sent to repair or retired
 *
 * @package default
 * @author Fran Iglesias
 */
class ActiveDeviceState extends AbstractDeviceState
{

	public function repair()
	{
		return new RepairingDeviceState();
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