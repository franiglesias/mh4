<?php

namespace AppBundle\Domain\It\Device;

use AppBundle\Domain\It\Device\ValueObjects\DeviceId;
use AppBundle\Domain\It\Device\Device;

interface DeviceRepositoryInterface {
	public function load(DeviceId $id);
	public function save(Device $Device);
}
?>