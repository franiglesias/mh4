<?php

namespace AppBundle\Tests\Infrastructure\Persistence;

// use AppBundle\Infrastructure\Persistence\InMemoryDeviceRepository;
use AppBundle\Domain\It\Device\Device;
use AppBundle\Domain\It\Device\ValueObjects as VO;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;
use AppBundle\Factories\DeviceFactory;


class InMemoryDeviceRespositoryTest extends \PHPUnit_Framework_Testcase {
	
    private $generator;
	private $Repo;

    public function setUp()
    {
        parent::setUp();
        $this->generator = new Version4Generator();
		$this->Repo = (new DeviceFactory())->getInMemoryRepository();
		
    }
	
	protected function getADevice()
	{
		$id = new VO\DeviceId($this->generator->generate());
		$name = new VO\DeviceName('Computer');
		$vendor = new VO\DeviceVendor('Apple', 'iMac');
		return Device::acquire($id, $name, $vendor);
	}
	
	
	
	public function testCanSaveADevice()
	{
		$Device = $this->getADevice();
		$this->Repo->save($Device);
		$nDevice = $this->Repo->load($Device->getId());
		$this->assertTrue($Device->equals($nDevice));
	}
	
}
?>