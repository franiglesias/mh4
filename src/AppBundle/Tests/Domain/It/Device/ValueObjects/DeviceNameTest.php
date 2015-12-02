<?php

namespace AppBundle\Tests\Domain\It\Device\ValueObjects;

use AppBundle\Domain\It\Device\ValueObjects\DeviceName;

/**
* Description
*/
class DeviceNameTest extends \PHPUnit_Framework_Testcase
{

	public function test_Name_Name_Is_Mandatory()
	{
		$this->assertInstanceOf('AppBundle\Domain\It\Device\ValueObjects\DeviceName', new DeviceName('Clasroom'));
	}
	
	
	/**
     * @expectedException PHPUnit_Framework_Error
     */
	public function test_No_Name_throws_Exception()
	{
		$Vendor = new DeviceName();
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 *
	 */
	public function test_Name_is_not_empty_string()
	{
		$Vendor = new DeviceName(false);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 *
	 */
	public function test_Name_is_not_null_string()
	{
		$Vendor = new DeviceName(null);
	}
	
}


?>