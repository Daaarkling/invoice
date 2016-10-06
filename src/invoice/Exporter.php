<?php

namespace Darkling\Invoice;


use Nette\Application\UI\ITemplate;
use mPDF;
use Nette\Application\UI\ITemplateFactory;
use Nette\SmartObject;

/**
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @copyright  Copyright (c) 2016 Jan Vaňura
 * @license    New BSD License
 */
class Exporter
{
	use SmartObject;

	const DEST_BROWSER = 'I';
	const DEST_BROWSER_DOWNLOAD = 'D';
	const DEST_SAVE = 'F';
	const DEST_STRING = 'S';


	/** @var Data */
	private $data;

	/** @var string */
	private $templatePath;

	/** @var  ITemplate */
	private $template;


	/**
	 * Initializes new Invoice.
	 *
	 * @param Data $data
	 * @param ITemplateFactory $templateFactory
	 */
	public function __construct(Data $data, ITemplateFactory $templateFactory)
	{
		$this->data = $data;
		$this->template = $templateFactory->createTemplate();
		$this->templatePath = __DIR__ . '/templates/invoice.latte';
	}


	/**
	 * Exports Invoice template via passed mPDF.
	 *
	 * @param string $name - if $dest is equal to F name must by provided
	 * @param string $dest - 	I: send the file inline to the browser. The plug-in is used if available. The name given by $filename is used when one selects the “Save as” option on the link generating the PDF.
	 *                            D: send to the browser and force a file download with the name given by $filename.
	 *                            F: save to a local file with the name given by $filename (may include a path).
	 *                            S: return the document as a string. $filename is ignored.
	 * @return string|NULL
	 */
	public function exportToPdf($name = NULL, $dest = self::DEST_BROWSER)
	{
		if ($name == NULL && $dest === self::DEST_SAVE) {
			throw new InvalidArgumentException('Property $name can NOT be nullable if $dest is set to F (save).');
		}

		$this->generate($this->template);
		$mPDF = new mPDF('utf-8');
		$mPDF->WriteHTML((string)$this->template);

		$result = $mPDF->Output($name, $dest);

		if ($dest === self::DEST_SAVE) {
			return $name;
		}
		return $result;
	}


	/**
	 * Generates the invoice to the defined template.
	 *
	 * @param ITemplate $template
	 * @return void
	 */
	private function generate(ITemplate $template)
	{
		$template->setFile($this->templatePath);

		$template->title = $this->data->getTitle();
		$template->id = $this->data->getId();
		$template->items = $this->data->getItems();
		$this->generateSupplier($template);
		$this->generateCustomer($template);
		$this->generateDates($template);
		$this->generateSymbols($template);
		$this->generateFinalValues($template);
	}

	/**
	 * Generates supplier data into template.
	 *
	 * @param ITemplate $template
	 * @return void
	 */
	private function generateSupplier(ITemplate $template)
	{
		$supplier = $this->data->getSupplier();
		$template->supplierName = $supplier->getName();
		$template->supplierStreet = $supplier->getStreet();
		$template->supplierHouseNumber = $supplier->getHouseNumber();
		$template->supplierCity = $supplier->getCity();
		$template->supplierZip = $supplier->getZip();
		$template->supplierIn = $supplier->getIn();
		$template->supplierTin = $supplier->getTin();
		$template->supplierAccountNumber = $supplier->getAccountNumber();
	}

	/**
	 * Generates customer data into template.
	 *
	 * @param ITemplate $template
	 * @return void
	 */
	private function generateCustomer(ITemplate $template)
	{
		$customer = $this->data->getCustomer();
		$template->customerName = $customer->getName();
		$template->customerStreet = $customer->getStreet();
		$template->customerHouseNumber = $customer->getHouseNumber();
		$template->customerCity = $customer->getCity();
		$template->customerZip = $customer->getZip();
		$template->customerIn = $customer->getIn();
		$template->customerTin = $customer->getTin();
		$template->customerAccountNumber = $customer->getAccountNumber();
	}

	/**
	 * Generates dates into template.
	 *
	 * @param ITemplate $template
	 * @return void
	 */
	private function generateDates(ITemplate $template)
	{
		$template->dateOfIssuance = $this->data->getDateOfIssuance();
		$template->expirationDate = $this->data->getExpirationDate();
		$template->dateOfVatRevenueRecognition = $this->data->getDateOfVatRevenueRecognition();
	}

	/**
	 * Generates symbols into template.
	 *
	 * @param ITemplate $template
	 * @return void
	 */
	private function generateSymbols(ITemplate $template)
	{
		$template->variableSymbol = $this->data->getVariableSymbol();
		$template->specificSymbol = $this->data->getSpecificSymbol();
		$template->constantSymbol = $this->data->getConstantSymbol();
	}

	/**
	 * Generates final values into template.
	 *
	 * @param ITemplate $template
	 * @return void
	 */
	private function generateFinalValues(ITemplate $template)
	{
		$template->finalUntaxedValue = $this->countFinalUntaxedValue();
		$template->finalTaxValue = $this->countFinalTaxValue();
		$template->finalValue = $this->countFinalValues();
	}

	/**
	 * Counts final untaxed value of all items.
	 *
	 * @return int
	 */
	private function countFinalUntaxedValue()
	{
		$sum = 0;
		foreach ($this->data->getItems() as $item) {
			$sum += $item->countUntaxedUnitValue() * $item->getUnits();
		}
		return $sum;
	}

	/**
	 * Counts final tax value of all items.
	 *
	 * @return int
	 */
	private function countFinalTaxValue()
	{
		$sum = 0;
		foreach ($this->data->getItems() as $item) {
			$sum += $item->countTaxValue();
		}
		return $sum;
	}

	/**
	 * Counts final value of all items.
	 *
	 * @return int
	 */
	private function countFinalValues()
	{
		$sum = 0;
		foreach ($this->data->getItems() as $item) {
			$sum += $item->countFinalValue();
		}
		return $sum;
	}


	/**
	 * Setter for path to template
	 *
	 * @param string $templatePath
	 */
	public function setTemplatePath($templatePath)
	{
		$this->templatePath = $templatePath;
	}

	/**
	 * @return string
	 */
	public function getTemplatePath()
	{
		return $this->templatePath;
	}

	/**
	 * @return Data
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * @param Data $data
	 */
	public function setData($data)
	{
		$this->data = $data;
	}


}
