<?php


namespace AppBundle\Tests\Commands;

use AppBundle\Domain\It\Device\Commands\DeviceCommandHandler;

use AppBundle\Domain\It\Device\Commands\AcquireDevice;
use AppBundle\Domain\It\Device\Commands\InstallDevice;
use AppBundle\Domain\It\Device\Commands\MoveDevice;
use AppBundle\Domain\It\Device\Commands\RetireDevice;

use AppBundle\Domain\It\Device\Events\DeviceWasAcquired;
use AppBundle\Domain\It\Device\Events\DeviceWasInstalled;
use AppBundle\Domain\It\Device\Events\DeviceWasMoved;
use AppBundle\Domain\It\Device\Events\DeviceWasRetired;

use AppBundle\Domain\It\Device\ValueObjects as VO;
use AppBundle\Factories\DeviceFactory;

/**
 * We drive the tests of our aggregate root through the command handler.
 *
 * A command handler scenario consists of three steps:
 *
 * - First, the scenario is setup with a history of events that already took place.
 * - Second, a command is dispatched (this is handled by the command handler)
 * - Third, the outcome is asserted. This can either be 1) some events are
 *   recorded, or 2) an exception is thrown.
 */
class DeviceCommandHandlerTest extends \Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase
{
    private $generator;

    public function setUp()
    {
        parent::setUp();
        $this->generator = new \Broadway\UuidGenerator\Rfc4122\Version4Generator();
    }

    protected function createCommandHandler(\Broadway\EventStore\EventStoreInterface $eventStore, \Broadway\EventHandling\EventBusInterface $eventBus)
    {
        $repository = (new DeviceFactory())->getInMemoryRepository($eventStore, $eventBus);

        return new DeviceCommandHandler($repository);
    }

    public function test_it_can_acquire_a_device()
    {
		$id = new VO\DeviceId($this->generator->generate());
		$name = new VO\DeviceName('Computer');
		$vendor = new VO\DeviceVendor('Apple', 'iMac');

        $this->scenario
            ->when(new AcquireDevice($id, $name, $vendor))
            ->then([new DeviceWasAcquired($id, $name, $vendor)]);
    }

	public function test_it_can_install_a_device()
	{
		$id = new VO\DeviceId($this->generator->generate());
		$name = new VO\DeviceName('Computer');
		$vendor = new VO\DeviceVendor('Apple', 'iMac');
		$location = new VO\DeviceLocation('Classroom');
		
		$this->scenario
			->withAggregateId($id->getValue())
			->given([new DeviceWasAcquired($id, $name, $vendor)])
			->when(new InstallDevice($id, $location))
			->then([new DeviceWasInstalled($id, $location)]);
	}


	public function test_it_can_move_a_device()
	{
		$id = new VO\DeviceId($this->generator->generate());
		$name = new VO\DeviceName('Computer');
		$vendor = new VO\DeviceVendor('Apple', 'iMac');
		$location = new VO\DeviceLocation('Classroom');
		$newLocation = new VO\DeviceLocation('Office');
		
		$this->scenario
			->withAggregateId($id->getValue())
			->given([new DeviceWasAcquired($id, $name, $vendor), new DeviceWasInstalled($id, $location)])
			->when(new MoveDevice($id, $newLocation))
			->then([new DeviceWasMoved($id, $newLocation)]);
	}
	
	/**
	 * @expectedException UnderflowException
	 */

	public function test_it_can_not_move_a_not_installed_device_throws_exception()
	{
		$id = new VO\DeviceId($this->generator->generate());
		$name = new VO\DeviceName('Computer');
		$vendor = new VO\DeviceVendor('Apple', 'iMac');
		$location = new VO\DeviceLocation('Classroom');
		$newLocation = new VO\DeviceLocation('Office');
		
		$this->scenario
			->withAggregateId($id->getValue())
			->given([new DeviceWasAcquired($id, $name, $vendor)])
			->when(new MoveDevice($id, $newLocation));
	}

	public function test_move_device_to_the_same_location_should_do_nothing()
	{
		$id = new VO\DeviceId($this->generator->generate());
		$name = new VO\DeviceName('Computer');
		$vendor = new VO\DeviceVendor('Apple', 'iMac');
		$location = new VO\DeviceLocation('Classroom');
		$newLocation = $location;
		
		$this->scenario
			->withAggregateId($id->getValue())
			->given([new DeviceWasAcquired($id, $name, $vendor), new DeviceWasInstalled($id, $location)])
			->when(new MoveDevice($id, $newLocation))
			->then([]);
	}
	
	/**
	 * @expectedException UnderflowException
	 * @param Device $Device 
	 */
	public function test_a_not_installed_device_cannot_be_retired()
	{
		$id = new VO\DeviceId($this->generator->generate());
		$name = new VO\DeviceName('Computer');
		$vendor = new VO\DeviceVendor('Apple', 'iMac');
		$reason = 'Retire';
		
		$this->scenario
			->withAggregateId($id->getValue())
			->given([new DeviceWasAcquired($id, $name, $vendor)])
			->when(new RetireDevice($id, $reason))
			->then([]);
	}
	
}
