<?php

namespace AppBundle\Tests\Domain\It\Device\ValueObjects;

use AppBundle\Domain\It\Device\ValueObjects\DeviceVendor;

/**
* Description
*/
class DeviceVendorTest extends \PHPUnit_Framework_Testcase
{

	public function test_Vendor_And_Model_Are_Mandatory()
	{
		$this->assertInstanceOf('AppBundle\Domain\It\Device\ValueObjects\DeviceVendor', new DeviceVendor('Apple', 'Imac'));
	}
	
	public function test_Serial_is_optional()
	{
		$this->assertInstanceOf('AppBundle\Domain\It\Device\ValueObjects\DeviceVendor', new DeviceVendor('Apple', 'Imac'));
		$this->assertInstanceOf('AppBundle\Domain\It\Device\ValueObjects\DeviceVendor', new DeviceVendor('Apple', 'Imac', '001'));
	}
	
	/**
     * @expectedException PHPUnit_Framework_Error
     */
	public function test_No_Vendor_Or_not_model_throws_Exception()
	{
		$Vendor = new DeviceVendor('Apple');
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 *
	 */
	public function test_Vendor_is_not_empty_string()
	{
		$Vendor = new DeviceVendor(false, 'iMac');
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 *
	 */
	public function test_Model_is_not_empty_string()
	{
		$Vendor = new DeviceVendor('Apple', false);
	}
	
}


?>