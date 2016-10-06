<?php

namespace Darkling\Invoice;

use Nette\SmartObject;

/**
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @copyright  Copyright (c) 2016 Jan Vaňura
 * @license    New BSD License
 */
class Participant
{
	use SmartObject;

	/** @var string */
	private $name;

	/** @var string */
	private $street;

	/** @var string */
	private $houseNumber;

	/** @var string */
	private $city;

	/** @var string */
	private $zip;

	/** @var string */
	private $in;

	/** @var string */
	private $tin;

	/** @var string */
	private $accountNumber;

	/**
	 * Initializes the Participant
	 *
	 * @param string $name
	 * @param string $street
	 * @param string $houseNumber
	 * @param string $city
	 * @param string $zip
	 */
	public function __construct($name, $street, $houseNumber, $city, $zip)
	{
		$this->name = $name;
		$this->street = $street;
		$this->houseNumber = $houseNumber;
		$this->city = $city;
		$this->zip = $zip;
	}

	/**
	 * Returns the name of participant.
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Returns the street of participant.
	 *
	 * @return string
	 */
	public function getStreet()
	{
		return $this->street;
	}

	/**
	 * Returns the house number of participant.
	 *
	 * @return string
	 */
	public function getHouseNumber()
	{
		return $this->houseNumber;
	}

	/**
	 * Returns the city of participant.
	 *
	 * @return string
	 */
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * Returns the zip of participant.
	 *
	 * @return string
	 */
	public function getZip()
	{
		return $this->zip;
	}

	/**
	 * Returns the identification number of participant.
	 *
	 * @return string
	 */
	public function getIn()
	{
		return $this->in;
	}

	/**
	 * Returns the tax identification number of participant.
	 *
	 * @return string
	 */
	public function getTin()
	{
		return $this->tin;
	}

	/**
	 * Returns the account number of participant.
	 *
	 * @return string
	 */
	public function getAccountNumber()
	{
		return $this->accountNumber;
	}

	/**
	 * @param string $name
	 * @return self
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @param string $street
	 * @return self
	 */
	public function setStreet($street)
	{
		$this->street = $street;
		return $this;
	}

	/**
	 * @param string $houseNumber
	 * @return self
	 */
	public function setHouseNumber($houseNumber)
	{
		$this->houseNumber = $houseNumber;
		return $this;
	}

	/**
	 * @param string $city
	 * @return self
	 */
	public function setCity($city)
	{
		$this->city = $city;
		return $this;
	}

	/**
	 * @param string $zip
	 * @return self
	 */
	public function setZip($zip)
	{
		$this->zip = $zip;
		return $this;
	}

	/**
	 * @param string $in
	 * @return self
	 */
	public function setIn($in)
	{
		$this->in = $in;
		return $this;
	}

	/**
	 * @param string $tin
	 * @return self
	 */
	public function setTin($tin)
	{
		$this->tin = $tin;
		return $this;
	}

	/**
	 * @param string $accountNumber
	 * @return self
	 */
	public function setAccountNumber($accountNumber)
	{
		$this->accountNumber = $accountNumber;
		return $this;
	}
}
