<?php

namespace AppBundle\Tests\Domain\It\Device;

use AppBundle\Domain\It\Device\Device;
use AppBundle\Domain\It\Device\VendorInformation;
use AppBundle\Domain\It\Device\DeviceStates\UninstalledDeviceState;
use AppBundle\Domain\It\Device\DeviceStates\ActiveDeviceState;
/**
* Description
*/
class DeviceTest extends \PHPUnit_Framework_Testcase
{
	public function testANewDeviceHasAName()
	{
		$Device = new Device('Device', new VendorInformation('Apple', 'iMac', 'Serial'));
		$this->assertAttributeEquals('Device', 'name', $Device);
		return $Device;
	}
	
	/**
	 * @depends testANewDeviceHasAName
	 *
	 */
	public function testANewDeviceHasVendorInformation(Device $Device)
	{
		$this->assertAttributeEquals(new VendorInformation('Apple', 'iMac', 'Serial'), 'vendor', $Device);
	}
	
	/**
	 * @depends testANewDeviceHasAName
	 *
	 */	
	public function testNewDeviceHasUninstalledState(Device $Device)
	{
		$this->assertAttributeEquals(new UninstalledDeviceState(), 'state', $Device);
	}
	
	/**
	 * @depends testANewDeviceHasAName
	 *
	 */	
	
	public function testNewDeviceCanBeInstalled(Device $Device)
	{
		$Device->install();
		$this->assertAttributeEquals(new ActiveDeviceState(), 'state', $Device);
	}

}

?>