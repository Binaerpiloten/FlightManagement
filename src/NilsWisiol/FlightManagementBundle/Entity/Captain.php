<?php

namespace NilsWisiol\FlightManagementBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Captain {

	/**
	 * database primary key
	 * 
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * captains name and surname
	 *
	 * @ORM\Column(type="string",length=255)
	 * @Assert\Regex("/([A-Z][A-Za-z]*) ([A-Z][A-Za-z]*)( ([A-Z][A-Za-z]*))*?/")
	 * @Assert\NotBlank
	 */
	protected $name;

	/**
	 * birthday
	 * 
	 * @ORM\Column(type="date",nullable=true)
	 */
	protected $birthday;

	public function __toString() {
		return "Captain $this->name";
	}

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getBirthday() {
		return $this->birthday;
	}

	public function setBirthday($birthday) {
		$this->birthday = $birthday;
	}

}
