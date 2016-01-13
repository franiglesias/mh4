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
	
	public function handleAcquireDevice(AcquireDevice $command)
	{
		$Device = Device::acquire($command->getDeviceId(), $command->getName(), $command->getVendor());
		$this->repository->save($Device);
	}
	
	public function handleInstallDevice(InstallDevice $command)
	{
		$Device = $this->repository->load($command->getDeviceId());
		$Device->install($command->getLocation());
		$this->repository->save($Device);
	}
	
	public function handleMoveDevice(MoveDevice $command)
	{
		$Device = $this->repository->load($command->getDeviceId());
		$Device->move($command->getLocation());
		$this->repository->save($Device);
	}
	
	public function handleRetireDevice(RetireDevice $command)
	{
		$Device = $this->repository->load($command->getDeviceId());
		$Device->retire($command->getReason());
		$this->repository->save($Device);
	}
	
}

?>