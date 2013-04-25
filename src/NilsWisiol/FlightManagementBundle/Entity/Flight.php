<?php

namespace NilsWisiol\FlightManagementBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Flight {

	/**
	 * database primary key
	 * 
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * flight number
	 *
	 * @ORM\Column(type="string",length=6)
	 * @Assert\Regex("/[A-Z][A-Z][0-9][0-9]?[0-9]?/")
	 * @Assert\NotBlank
	 */
	protected $number;
	
	/**
	 * origin airport code
	 * 
	 * @ORM\Column(type="string",length=3)
	 * @Assert\Regex("/[A-Z][A-Z][A-Z]/")
	 */
	protected $origin;
	
	/**
	 * destination airport code
	 * 
	 * @ORM\Column(type="string",length=3)
	 * @Assert\Regex("/[A-Z][A-Z][A-Z]/")
	 */
	protected $destination;
	
	/**
	 * the flight's captain
	 * 
	 * @ORM\ManyToOne(targetEntity="Captain")
	 */
	protected $captain;
	
	public function getId() {
		return $this->id;
	}
	
	public function getNumber() {
		return $this->number;
	}
	
	public function setNumber($number) {
		$this->number = $number;
	}
	
	public function getOrigin() {
		return $this->origin;
	}
	
	public function setOrigin($origin) {
		$this->origin = $origin;
	}
	
	public function getDestination() {
		return $this->destination;
	}
	
	public function setDestination($destination) {
		$this->destination = $destination;
	}
	
	
	public function getCaptain() {
		return $this->captain;
	}
	
	public function setCaptain($captain) {
		$this->captain = $captain;
	}
	
	public function isCaptain($captain) {
		if ($captain == null || $this->captain == null)
			return $captain == $this->captain;
		return $captain->getId() == $this->captain->getId();
	}
	
	public function hasCaptain() {
		return $this->captain == null;
	}

	public function __toString() {
		return "flight $this->number ($this->origin -> $this->destination)";
	}
	
}