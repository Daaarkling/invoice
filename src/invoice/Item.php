<?php

namespace Darkling\Invoice;

use Nette\SmartObject;


/**
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @copyright  Copyright (c) 2016 Jan Vaňura
 * @license    New BSD License
 */
class Item
{
	use SmartObject;

	/** @var string */
	private $description;

	/** @var Tax */
	private $tax;

	/** @var double */
	private $unitValue;

	/** @var string */
	private $unitType;

	/** @var int */
	private $units;

	/** @var boolean */
	private $unitValueIsTaxed;

	/**
	 * Initializes the Item.
	 *
	 * @param string $description
	 * @param int $units
	 * @param double $unitValue
	 * @param Tax $tax
	 * @param boolean $unitValueIsTaxed
	 * @param string $unitType like ks, h, kg
	 */
	public function __construct($description, $units, $unitValue, Tax $tax, $unitValueIsTaxed = TRUE, $unitType = '')
	{
		$this->description = $description;
		$this->units = $units;
		$this->unitValue = $unitValue;
		$this->tax = $tax;
		$this->unitValueIsTaxed = $unitValueIsTaxed;
		$this->unitType = $unitType;
	}


	/**
	 * Returns the value of taxes for all units.
	 *
	 * @return double
	 */
	public function countTaxValue()
	{
		return ($this->countTaxedUnitValue() - $this->countUntaxedUnitValue()) * $this->getUnits();
	}

	/**
	 * Returns the taxed value of one unit.
	 *
	 * @return double
	 */
	private function countTaxedUnitValue()
	{
		if ($this->isUnitValueTaxed()) {
			return $this->getUnitValue();
		} else {
			return $this->getUnitValue() * $this->getTax()->inUpperDecimal();
		}
	}

	/**
	 * Returns the value of unit without tax.
	 *
	 * @return double
	 */
	public function countUntaxedUnitValue()
	{
		if ($this->isUnitValueTaxed()) {
			return $this->getUnitValue() / $this->getTax()->inUpperDecimal();
		} else {
			return $this->getUnitValue();
		}
	}

	/**
	 * Returns the final value of all taxed units.
	 *
	 * @return double
	 */
	public function countFinalValue()
	{
		return $this->getUnits() * $this->countTaxedUnitValue();
	}


	/**
	 * Returns the description of the item.
	 *
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Returns the tax of the item.
	 *
	 * @return Tax
	 */
	public function getTax()
	{
		return $this->tax;
	}

	/**
	 * Returns the value of one unit of the item.
	 *
	 * @return double
	 */
	public function getUnitValue()
	{
		return $this->unitValue;
	}

	/**
	 * Returns TRUE, if the unit value is taxed (otherwise FALSE).
	 *
	 * @return boolean
	 */
	public function isUnitValueTaxed()
	{
		return $this->unitValueIsTaxed;
	}

	/**
	 * Returns the number of item units.
	 *
	 * @return int
	 */
	public function getUnits()
	{
		return $this->units;
	}

	/**
	 * Returns type of units like ks, h, kg
	 *
	 * @return string
	 */
	public function getUnitType()
	{
		return $this->unitType;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * @param Tax $tax
	 */
	public function setTax($tax)
	{
		$this->tax = $tax;
	}

	/**
	 * @param float $unitValue
	 */
	public function setUnitValue($unitValue)
	{
		$this->unitValue = $unitValue;
	}

	/**
	 * @param string $unitType
	 */
	public function setUnitType($unitType)
	{
		$this->unitType = $unitType;
	}

	/**
	 * @param int $units
	 */
	public function setUnits($units)
	{
		$this->units = $units;
	}

	/**
	 * @param boolean $unitValueIsTaxed
	 */
	public function setUnitValueIsTaxed($unitValueIsTaxed)
	{
		$this->unitValueIsTaxed = $unitValueIsTaxed;
	}
}
