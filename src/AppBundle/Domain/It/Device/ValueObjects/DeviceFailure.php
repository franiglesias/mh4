<?php

namespace AppBundle\Domain\It\Device\ValueObjects;


/**
 * Represents a Failure of a device
 *
 * @package default
 * @author Francisco Iglesias Gómez
 */
class DeviceFailure {
	
	private $description;
	private $detected;
	private $reported;
	private $reporter;
	
	public function __construct($description, $reporter, \DateTimeImmutable $detected)
	{
		$this->description = $description;
		$this->reporter = $reporter;
		$this->detected = $detected;
		$this->reported = new \DateTimeImmutable();
	}
	
	public function getDescription()
	{
		return $this->description;
	}
	
	public function getReported()
	{
		return $this->reported();
	}
	
	public function getReporter()
	{
		return $this->reporter;
	}
	
	public function getDetected()
	{
		return $this->detected;
	}
}
?>