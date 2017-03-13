<?php

namespace Darkling\Invoice;


use DateTime;
use Nette\SmartObject;


/**
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @copyright  Copyright (c) 2016 Jan Vaňura
 * @license    New BSD License
 */
class Data
{
	use SmartObject;

	/** @var string */
	private $title;

	/** @var string */
	private $id;

	/** @var Participant */
	private $supplier;

	/** @var Participant */
	private $customer;

	/** @var int */
	private $variableSymbol = 0;

	/** @var int */
	private $constantSymbol = 0;

	/** @var int */
	private $specificSymbol = 0;

	/** @var DateTime */
	private $expirationDate;

	/** @var DateTime */
	private $dateOfIssuance;

	/** @var DateTime */
	private $dateOfVatRevenueRecognition;

	/** @var Item[] */
	private $items = [];

	/**
	 * Data constructor.
	 *
	 * @param int $id
	 * @param string $title
	 * @param Participant $supplier
	 * @param Participant $customer
	 * @param DateTime $expirationDate
	 * @param DateTime $dateOfIssuance
	 * @param Item[] $items
	 */
	public function __construct($id, $title, Participant $supplier, Participant $customer, DateTime $expirationDate, DateTime $dateOfIssuance, array $items)
	{
		$this->id = $id;
		$this->title = $title;
		$this->supplier = $supplier;
		$this->customer = $customer;
		$this->expirationDate = $expirationDate;
		$this->dateOfIssuance = $dateOfIssuance;
		$this->addItems($items);
	}

	/**
	 * Adds array of items to the invoice.
	 *
	 * @param Item[] $items
	 * @return self
	 */
	public function addItems($items)
	{
		foreach ($items as $item) {
			$this->addItem($item);
		}
		return $this;
	}

	/**
	 * Adds an item to the invoice.
	 *
	 * @param Item $item
	 * @return self
	 */
	public function addItem(Item $item)
	{
		$this->items[] = $item;
		return $this;
	}

	/**
	 * Sets the variable symbol.
	 *
	 * @param int $variableSymbol
	 * @return self
	 */
	public function setVariableSymbol($variableSymbol)
	{
		$this->variableSymbol = $variableSymbol;
		return $this;
	}

	/**
	 * Sets the constant symbol.
	 *
	 * @param int $constantSymbol
	 * @return self
	 */
	public function setConstantSymbol($constantSymbol)
	{
		$this->constantSymbol = $constantSymbol;
		return $this;
	}

	/**
	 * Sets the specific symbol.
	 *
	 * @param int $specificSymbol
	 * @return self
	 */
	public function setSpecificSymbol($specificSymbol)
	{
		$this->specificSymbol = $specificSymbol;
		return $this;
	}

	/**
	 * Sets the date of VAT revenue recognition.
	 *
	 * @param DateTime $dateOfTaxablePayment
	 * @return self
	 */
	public function setDateOfVatRevenueRecognition(DateTime $dateOfTaxablePayment)
	{
		$this->dateOfVatRevenueRecognition = $dateOfTaxablePayment;
		return $this;
	}


	/**
	 * Returns the invoice title.
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Returns the invoice id.
	 *
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Returns the invoice supplier.
	 *
	 * @return Participant
	 */
	public function getSupplier()
	{
		return $this->supplier;
	}

	/**
	 * Returns the invoice customer.
	 *
	 * @return Participant
	 */
	public function getCustomer()
	{
		return $this->customer;
	}

	/**
	 * Returns the variable symbol.
	 *
	 * @return int
	 */
	public function getVariableSymbol()
	{
		return $this->variableSymbol;
	}

	/**
	 * Returns the constant symbol.
	 *
	 * @return int
	 */
	public function getConstantSymbol()
	{
		return $this->constantSymbol;
	}

	/**
	 * Returns the specific symbol.
	 *
	 * @return int
	 */
	public function getSpecificSymbol()
	{
		return $this->specificSymbol;
	}

	/**
	 * Returns the expiration date in defined format.
	 *
	 * @param string $format
	 * @return string
	 */
	public function getExpirationDate($format = 'd.m.Y')
	{
		return $this->expirationDate->format($format);
	}

	/**
	 * Returns the date of issuance in defined format.
	 *
	 * @param string $format
	 * @return string
	 */
	public function getDateOfIssuance($format = 'd.m.Y')
	{
		return $this->dateOfIssuance->format($format);
	}

	/**
	 * Returns the date of VAT revenue recognition in defined format.
	 *
	 * @param string $format
	 * @return string
	 */
	public function getDateOfVatRevenueRecognition($format = 'd.m.Y')
	{
		return $this->dateOfVatRevenueRecognition === NULL ? '' : $this->dateOfVatRevenueRecognition->format($format);
	}

	/**
	 * Returns the array of items.
	 *
	 * @return Item[]
	 */
	public function getItems()
	{
		return $this->items;
	}

}
