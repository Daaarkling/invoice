# Invoice to PDF

Simple tool to generate PDF invoices for Nette Framework. Based on [Eciovni](https://github.com/obrejla/Eciovni) project.

Requirements
----------
 * [Nette Frameword](http://nette.org/)
 * [mPDF](http://mpdf.github.io/)

Installation
----------
Easiest way to install is to use composer.
```sh
composer require darkling/invoice
```

Configuration
----------
Just register extension in your config neon file.
```yml
extensions:
	- Darkling\Invoice\DI\Extension
```

Usage
----------
Example below shows basic usage. You can also use it inside 'model' class, just demand IExporterFactory dependency. There are four ways which you can handle output file (browser, browser force download, string, save). If you want to change template just provide path to latte file. All should be clear from example.
```php
// inside Presenter class

/** 
 * @var  IExporterFactory 
 * @inject 
 */
public $exporterFactory;



public function renderDefault() {

	$supplier = new Participant('Dodavatel Dodavatelovič', 'Ulička', 15, 'Městečko', '555 33');
	$supplier->setIn('562656959')->setTin('CZ562656959')->setAccountNumber('015160/15114');

	$customer = new Participant('Zákazník Zákazníkovič', 'Ulice', 51, 'Město', '333 55');

	$items[] = new Item('Item 1', 2, 100, Tax::fromPercent(21), TRUE);
	$items[] = new Item('Item 2', 1, 50, Tax::fromPercent(21), TRUE, 'kg');

	$data = new Data(1, 'Faktura', $supplier, $customer, new \DateTime('2016-01-01'), new \DateTime('2000-02-01'), $items);
	$data->setVariableSymbol('0101010')->setConstantSymbol('21212121')->setSpecificSymbol('313131313');

	$exporter = $this->exporterFactory->create($data);
	//$exporter->setTemplatePath(__DIR__ . '/path/to/your/template.latte');

	$name = __DIR__ . '/path/where/to/save/file.pdf';
	$pdf = $exporter->exportToPdf($name, Exporter::DEST_SAVE);
}
```

Licence
----------
New BSD License