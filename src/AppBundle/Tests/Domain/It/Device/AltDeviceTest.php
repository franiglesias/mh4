<?php

namespace AppBundle\Test\Domain\It\Device;

use AppBundle\Domain\It\Device\Device;
use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Broadway\EventSourcing\AggregateFactory\NamedConstructorAggregateFactory;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;
use AppBundle\Domain\It\Device\ValueObjects as VO;
use AppBundle\Domain\It\Device\Events as Event;
/**.
 *
 * An aggregate root scenario consists of three steps:
 *
 * - First, the scenario is setup with a history of events that already took place.
 * - Second, an action is taken on the aggregate.
 * - Third, the outcome is asserted. This can either be 1) some events are
 *   recorded, or 2) an exception is thrown.
 */
class AltDeviceTest extends AggregateRootScenarioTestCase
{
    private $generator;

    public function setUp()
    {
        parent::setUp();
        $this->generator = new Version4Generator();
    }

    protected function getAggregateRootClass()
    {
        return Device::class;
    }
	
    protected function getAggregateRootFactory()
    {
        return new NamedConstructorAggregateFactory('reconstitute');
    }

	public function test_it_can_acquire_device()
	{
		$id = new VO\DeviceId($this->generator->generate());
		$name = new VO\DeviceName('Computer');
		$vendor = new VO\DeviceVendor('Apple', 'iMac');
		
		$this->scenario
			->when(function () use ($id, $name, $vendor) {
				return Device::acquire($id, $name, $vendor);
			})
			->then([new Event\DeviceWasAcquired($id, $name, $vendor)]);
	}
	
	/**
	 * @expectedException OutOfBoundsException
	 * @param Device $Device 
	 */
	public function test_uninstalled_device_cannot_be_moved()
	{
		$id = new VO\DeviceId($this->generator->generate());
		$name = new VO\DeviceName('Computer');
		$vendor = new VO\DeviceVendor('Apple', 'iMac');
		$location = new VO\DeviceLocation('Classroom');
		
		$this->scenario
			->withAggregateId($id)
			->given([new Event\DeviceWasAcquired($id, $name, $vendor)])
			->when(function ($device) use ($location) {
				$device->move($location);
			});
	}
	
	public function test_it_can_install_an_acquired_device()
	{
		$id = new VO\DeviceId($this->generator->generate());
		$name = new VO\DeviceName('Computer');
		$vendor = new VO\DeviceVendor('Apple', 'iMac');
		$location = new VO\DeviceLocation('Classroom');
		
		$this->scenario
			->withAggregateId($id)
			->given([new Event\DeviceWasAcquired($id, $name, $vendor)])
			->when(function ($device) use ($location) {
				$device->install($location);
			})
			->then([new Event\DeviceWasInstalled($id, $location)]);
	}
	
	/**
	 * @expectedException OutOfBoundsException
	 * @param Device $Device 
	 */	
	public function test_Installed_Device_Can_Not_Be_Installed_Again()
	{
		$id = new VO\DeviceId($this->generator->generate());
		$name = new VO\DeviceName('Computer');
		$vendor = new VO\DeviceVendor('Apple', 'iMac');
		$location = new VO\DeviceLocation('Classroom');
		$newLocation = new VO\DeviceLocation('Other classroom');
		
		$this->scenario
			->withAggregateId($id)
			->given([
				new Event\DeviceWasAcquired($id, $name, $vendor),
				new Event\DeviceWasInstalled($id, $location)])
			->when(function ($device) use ($newLocation) {
				$device->install($newLocation);
			});
	}
	
	public function test_Installed_Device_Can_Be_Moved_To_Another_Location()
	{
		$id = new VO\DeviceId($this->generator->generate());
		$name = new VO\DeviceName('Computer');
		$vendor = new VO\DeviceVendor('Apple', 'iMac');
		$location = new VO\DeviceLocation('Classroom');
		$newLocation = new VO\DeviceLocation('Other classroom');
		
		$this->scenario
			->withAggregateId($id)
			->given([
				new Event\DeviceWasAcquired($id, $name, $vendor),
				new Event\DeviceWasInstalled($id, $location)])
			->when(function ($device) use ($newLocation) {
				$device->move($newLocation);
			})
			->then([new Event\DeviceWasMoved($id, $newLocation)]);
	}
	
	public function test_Move_to_the_same_location_does_nothing()
	{
		$id = new VO\DeviceId($this->generator->generate());
		$name = new VO\DeviceName('Computer');
		$vendor = new VO\DeviceVendor('Apple', 'iMac');
		$location = new VO\DeviceLocation('Classroom');
		
		$this->scenario
			->withAggregateId($id)
			->given([
				new Event\DeviceWasAcquired($id, $name, $vendor),
				new Event\DeviceWasInstalled($id, $location)])
			->when(function ($device) use ($location) {
				$device->move($location);
			})
			->then([]);
	}

	public function test_Installed_Device_Can_Fail()
	{
		$id = new VO\DeviceId($this->generator->generate());
		$name = new VO\DeviceName('Computer');
		$vendor = new VO\DeviceVendor('Apple', 'iMac');
		$failure = new VO\DeviceFailure('Failure', 'Reporter', new \DateTimeImmutable());
		$location = new VO\DeviceLocation('Classroom');
		
		$this->scenario
			->withAggregateId($id)
			->given([
				new Event\DeviceWasAcquired($id, $name, $vendor),
				new Event\DeviceWasInstalled($id, $location)])
			->when(function ($device) use ($failure) {
				$device->fail($failure);
			})
			->then([new Event\DeviceFailed($id, $failure)]);
	}
	
	public function test_a_failed_device_can_be_sent_to_repair()
	{
		$id = new VO\DeviceId($this->generator->generate());
		$name = new VO\DeviceName('Computer');
		$vendor = new VO\DeviceVendor('Apple', 'iMac');
		$failure = new VO\DeviceFailure('Failure', 'Reporter', new \DateTimeImmutable());
		$location = new VO\DeviceLocation('Classroom');
		$technician = new VO\DeviceTechnician('SAT');
		
		$this->scenario
			->withAggregateId($id)
			->given([
				new Event\DeviceWasAcquired($id, $name, $vendor),
				new Event\DeviceWasInstalled($id, $location),
				new Event\DeviceFailed($id, $failure)])
			->when(function ($device) use ($failure, $technician) {
				$device->sendToRepair($failure, $technician);
			})
			->then([new Event\DeviceWasSentToRepair($id, $failure, $technician)]);
		
	}
	
    // /**
    //  * @test
    //  */
    // public function it_can_invite_someone()
    // {
    //     $id = $this->generator->generate();
    //
    //     $this->scenario
    //         ->when(function () use ($id) {
    //             return Invitation::invite($id, 'asm89');
    //         })
    //         ->then([new InvitedEvent($id, 'asm89')]);
    // }
    //
    // /**
    //  * @test
    //  */
    // public function new_invites_can_be_accepted()
    // {
    //     $id = $this->generator->generate();
    //
    //     $this->scenario
    //         ->withAggregateId($id)
    //         ->given([new InvitedEvent($id, 'asm89')])
    //         ->when(function ($invite) {
    //             $invite->accept();
    //         })
    //         ->then([new AcceptedEvent($id)]);
    // }
    //
    // /**
    //  * @test
    //  */
    // public function accepting_an_accepted_invite_yields_no_change()
    // {
    //     $id = $this->generator->generate();
    //
    //     $this->scenario
    //         ->withAggregateId($id)
    //         ->given([new InvitedEvent($id, 'asm89'), new AcceptedEvent($id)])
    //         ->when(function ($aggregate) {
    //             $aggregate->accept();
    //         })
    //         ->then([]);
    // }
    //
    // /**
    //  * @test
    //  * @expectedException RuntimeException
    //  * @expectedExceptionMessage Already accepted.
    //  */
    // public function an_accepted_invite_cannot_be_declined()
    // {
    //     $id = $this->generator->generate();
    //
    //     $this->scenario
    //         ->withAggregateId($id)
    //         ->given([new InvitedEvent($id, 'asm89'), new AcceptedEvent($id)])
    //         ->when(function ($invite) {
    //             $invite->decline();
    //         });
    // }
    //
    // /**
    //  * @test
    //  */
    // public function new_invites_can_be_declined()
    // {
    //     $id = $this->generator->generate();
    //
    //     $this->scenario
    //         ->withAggregateId($id)
    //         ->given([new InvitedEvent($id, 'asm89')])
    //         ->when(function ($invite) {
    //             $invite->decline();
    //         })
    //         ->then([new DeclinedEvent($id)]);
    // }
    //
    // /**
    //  * @test
    //  */
    // public function declining_a_declined_invite_yields_no_change()
    // {
    //     $id = $this->generator->generate();
    //
    //     $this->scenario
    //         ->withAggregateId($id)
    //         ->given([new InvitedEvent($id, 'asm89'), new DeclinedEvent($id)])
    //         ->when(function ($invite) {
    //             $invite->decline();
    //         })
    //         ->then([]);
    // }
    //
    // /**
    //  * @test
    //  * @expectedException RuntimeException
    //  * @expectedExceptionMessage Already declined.
    //  */
    // public function a_declined_invite_cannot_be_accepted()
    // {
    //     $id = $this->generator->generate();
    //
    //     $this->scenario
    //         ->withAggregateId($id)
    //         ->given([new InvitedEvent($id, 'asm89'), new DeclinedEvent($id)])
    //         ->when(function ($invite) {
    //             $invite->accept();
    //         });
    // }
}
