<?php

namespace AppBundle\Domain\It\Device\Commands;

use AppBundle\Domain\It\Device\DeviceRepositoryInterface;
use AppBundle\Domain\It\Device\Device;
use AppBundle\Domain\It\Device\ValueObjects as VO;

class DeviceCommandHandler extends \Broadway\CommandHandling\CommandHandler{
    private $repository;

    public function __construct(DeviceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
	
	public function handleAcquireDevice(AcquireDevice $acquireDevice)
	{
		$Device = Device::acquire($acquireDevice->getDeviceId(), $acquireDevice->getName(), $acquireDevice->getVendor());
		$this->repository->save($Device);
	}
	
}

?>