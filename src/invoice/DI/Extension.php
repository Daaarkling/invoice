<?php

namespace Darkling\Invoice\DI;

use Nette;
use Darkling\Invoice\IExporterFactory;

class Extension extends Nette\DI\CompilerExtension
{
	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('IInvoiceExporterFactory'))
			->setImplement(IExporterFactory::class);
	}


}
