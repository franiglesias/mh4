<?php


namespace AppBundle\Tests\Commands;

use AppBundle\Domain\It\Device\Commands\AcquireDevice;
use AppBundle\Domain\It\Device\Events\DeviceWasAcquired;
use AppBundle\Domain\It\Device\Commands\DeviceCommandHandler;
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
        $repository = (new DeviceFactory())->getInMemoryRepository();

        return new DeviceCommandHandler($repository);
    }

    /**
     * @test
     */
    public function test_it_can_acquire_a_device()
    {
		$id = new VO\DeviceId($this->generator->generate());
		$name = new VO\DeviceName('Computer');
		$vendor = new VO\DeviceVendor('Apple', 'iMac');

        $this->scenario
            ->when(new AcquireDevice($id, $name, $vendor))
            ->then([new DeviceWasAcquired($id, $name, $vendor)]);
    }

    // /**
   //   * @test
   //   */
   //  public function new_invites_can_be_accepted()
   //  {
   //      $id = $this->generator->generate();
   //
   //      $this->scenario
   //          ->withAggregateId($id)
   //          ->given([new InvitedEvent($id, 'asm89')])
   //          ->when(new AcceptCommand($id))
   //          ->then([new AcceptedEvent($id)]);
   //  }
   //
   //  /**
   //   * @test
   //   */
   //  public function accepting_an_accepted_invite_yields_no_change()
   //  {
   //      $id = $this->generator->generate();
   //
   //      $this->scenario
   //          ->withAggregateId($id)
   //          ->given([new InvitedEvent($id, 'asm89'), new AcceptedEvent($id)])
   //          ->when(new AcceptCommand($id))
   //          ->then([]);
   //  }
   //
   //  /**
   //   * @test
   //   * @expectedException RuntimeException
   //   * @expectedExceptionMessage Already accepted.
   //   */
   //  public function an_accepted_invite_cannot_be_declined()
   //  {
   //      $id = $this->generator->generate();
   //
   //      $this->scenario
   //          ->withAggregateId($id)
   //          ->given([new InvitedEvent($id, 'asm89'), new AcceptedEvent($id)])
   //          ->when(new DeclineCommand($id));
   //  }
   //
   //  /**
   //   * @test
   //   */
   //  public function new_invites_can_be_declined()
   //  {
   //      $id = $this->generator->generate();
   //
   //      $this->scenario
   //          ->withAggregateId($id)
   //          ->given([new InvitedEvent($id, 'asm89')])
   //          ->when(new DeclineCommand($id))
   //          ->then([new DeclinedEvent($id)]);
   //  }
   //
   //  /**
   //   * @test
   //   */
   //  public function declining_a_declined_invite_yields_no_change()
   //  {
   //      $id = $this->generator->generate();
   //
   //      $this->scenario
   //          ->withAggregateId($id)
   //          ->given([new InvitedEvent($id, 'asm89'), new DeclinedEvent($id)])
   //          ->when(new DeclineCommand($id))
   //          ->then([]);
   //  }
   //
   //  /**
   //   * @test
   //   * @expectedException RuntimeException
   //   * @expectedExceptionMessage Already declined.
   //   */
   //  public function a_declined_invite_cannot_be_accepted()
   //  {
   //      $id = $this->generator->generate();
   //
   //      $this->scenario
   //          ->withAggregateId($id)
   //          ->given([new InvitedEvent($id, 'asm89'), new DeclinedEvent($id)])
   //          ->when(new AcceptCommand($id));
   //  }
}
