<?php

namespace AppBundle\Domain\It\Device\DeviceStates;

/**
* Abstract class for Device States. 
* Define allowed transitions and provides a fallback for transitions not supported by a ConcreteState
*/
abstract class AbstractDeviceState implements DeviceStateInterface
{
		
	public function install()
	{
		throw new \OutOfBoundsException('Device state install transition not allowed', 1);
	}
	
	public function fail()
	{
		throw new \OutOfBoundsException('Device state fail transition not allowed', 1);
	}

	public function repair()
	{
		throw new \OutOfBoundsException('Device state repair transition not allowed', 1);
	}
	
	public function fix()
	{
		throw new \OutOfBoundsException('Device state install transition not allowed', 1);
	}
	
	public function retire()
	{
		throw new \OutOfBoundsException('Device state retire transition not allowed', 1);
	}
	
	public function verbose()
	{
		return '';
	}
	
}

?>