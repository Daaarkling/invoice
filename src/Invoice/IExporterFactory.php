<?php

namespace Darkling\Invoice;


/**
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @copyright  Copyright (c) 2016 Jan Vaňura
 * @license    New BSD License
 */
interface IExporterFactory
{
	/**
	 * @param Data $data
	 * @return Exporter
	 */
	public function create(Data $data);
}
