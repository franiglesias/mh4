<?php

namespace AppBundle\Domain\It\Device\DeviceStates;
/**
 * Defines the transitions between the different Device States
 *
 */
interface DeviceStateInterface {
	public function install();
	public function fail();
	public function sendToRepair();
	public function fix();
	public function retire();
}

?>