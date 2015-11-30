<?php

namespace AppBundle\Domain\It\Device\DeviceStates;

use AppBundle\Domain\It\Device\Device;
use AppBundle\Domain\It\Failure\Failure;

interface DeviceStateInterface {
	public function install($location, \DateTimeImmutable $date);
	public function repair(Failure $Failure, $technician);
	public function retire($reason);
	public function fix();
}

?>