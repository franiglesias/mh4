<?php

namespace AppBundle\Domain\It\Device\DeviceStates;

use AppBundle\Domain\It\Device\DeviceStates\DeviceStateInterface;
use AppBundle\Domain\It\Device\Device;
use AppBundle\Domain\It\Failure\Failure;
/**
* Abstract class for Device States. 
* Define allowed transitions and provides a fallback for transitions not supported by a ConcreteState
*/
abstract class AbstractDeviceState implements DeviceStateInterface
{
	protected $Device;
	
	public function __construct(Device $Device)
	{
		$this->Device = $Device;
	}
	
	public function install($location, \DateTimeImmutable $date)
	{
		throw new \OutOfBoundsException('Device state install transition not allowed', 1);
	}

	public function repair(Failure $Failure, $technician)
	{
		throw new \OutOfBoundsException('Device state repair transition not allowed', 1);
	}
	
	public function fix()
	{
		throw new \OutOfBoundsException('Device state install transition not allowed', 1);
	}
	
	public function retire($reason)
	{
		throw new \OutOfBoundsException('Device state retire transition not allowed', 1);
	}
	
	public function verbose()
	{
		return '';
	}
	
}

?>