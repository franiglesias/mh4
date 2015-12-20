<?php

interface DeviceRepositoryInterface {
	public function load(DeviceId $id);
	public function save(Device $Device);
}
?>