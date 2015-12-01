<?php

interface DeviceRepositoryInterface {
	public function get();
	public function findAll();
	public function findSatisfying(DeviceSpecification $DeviceSpecification);
}
?>