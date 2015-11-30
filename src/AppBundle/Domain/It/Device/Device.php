<?php

namespace AppBundle\Domain\It\Device;

use AppBundle\Domain\It\Device\DeviceId;
use AppBundle\Domain\It\Device\DeviceStates\DeviceStateInterface;
use AppBundle\Domain\It\Device\DeviceStates\UninstalledDeviceState;

use AppBundle\Domain\It\Failure\Failure;

/**
* Represents a Device.
* 
* A Device is any system used in the organization.
* Has identity given by his name
* Has lifecyle: acquired -> installed [-> Repaired ->Fixed]  -> Retired
*/
class Device implements DeviceStateInterface
{

	
}
?>