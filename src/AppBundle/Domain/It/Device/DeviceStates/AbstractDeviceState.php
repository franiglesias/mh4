<?php

namespace AppBundle\Domain\It\Device\DeviceStates;

/**
* Abstract class for Device States. 
* Define allowed transitions and provides a fallback for transitions not supported by a ConcreteState
*/
abstract class AbstractDeviceState
{
		
	public function install()
	{
		throw new \UnderflowException('Device '.get_class($this).' install transition not allowed', 1);
	}
	
	public function fail()
	{
		throw new \UnderflowException('Device '.get_class($this).' fail transition not allowed', 1);
	}

	public function sendToRepair()
	{
		throw new \UnderflowException('Device '.get_class($this).' sendToRepair transition not allowed', 1);
	}
	
	public function fix()
	{
		throw new \UnderflowException('Device '.get_class($this).' install transition not allowed', 1);
	}
	
	public function retire()
	{
		throw new \UnderflowException('Device '.get_class($this).' retire transition not allowed', 1);
	}
	
	public function verbose()
	{
		return '';
	}
	
}

?>