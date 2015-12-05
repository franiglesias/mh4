<?php

namespace AppBundle\Tests\Domain\It\Device\ValueObjects;

use AppBundle\Domain\It\Device\ValueObjects\DeviceLocation;

/**
* Description
*/
class DeviceLocationTest extends \PHPUnit_Framework_Testcase
{

	public function test_Location_Name_Is_Mandatory()
	{
		$this->assertInstanceOf('AppBundle\Domain\It\Device\ValueObjects\DeviceLocation', new DeviceLocation('Clasroom'));
	}
	
	
	/**
     * @expectedException PHPUnit_Framework_Error
     */
	public function test_No_Location_throws_Exception()
	{
		$Vendor = new DeviceLocation();
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 *
	 */
	public function test_Location_is_not_empty_string()
	{
		$Vendor = new DeviceLocation(false);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 *
	 */
	public function test_Location_is_not_null_string()
	{
		$Vendor = new DeviceLocation(null);
	}
	
	public function test_equality_of_locations()
	{
		$location = new DeviceLocation('Classroom');
		$this->assertTrue($location->equals(new DeviceLocation('classroom')));
		$this->assertTrue($location->equals(new DeviceLocation('CLASSROOM')));
		$this->assertTrue($location->equals(new DeviceLocation('ClassRoom')));
	}
	
}


?>