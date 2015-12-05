<?php

namespace AppBundle\Tests\Domain\It\Device\ValueObjects;

use AppBundle\Domain\It\Device\ValueObjects\DeviceId;

class DeviceIdTest extends \PHPUnit_Framework_Testcase {
	
	public function test_new_DeviceId_is_valid_uuid_v4()
	{
		$pattern ='/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';
		$this->assertRegExp($pattern, (new DeviceId())->getValue());
	}
	
	public function test_Can_init_DeviceId_with_arbitrary_value()
	{
		$this->assertEquals(12, (new DeviceId(12))->getValue());
	}
	
	public function test_equality_two_id_are_the_same()
	{
		$id1 = new DeviceId('abc');
		$this->assertTrue($id1->equals(new DeviceId('abc')));
	}
}

?>