<?php

namespace AppBundle\Domain\It\Device\DeviceStates;

interface DeviceStateInterface {
	public function install();
	public function fail();
	public function sendToRepair();
	public function fix();
	public function retire();
}

?>