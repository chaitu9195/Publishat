<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * Thin PhpSpreadsheet wrapper (replaces PHPExcel).
 */
class Excel extends Spreadsheet
{
	public function __construct()
	{
		parent::__construct();
	}
}

/**
 * Compatibility alias for PHPExcel_IOFactory::load()
 */
if (!class_exists('PHPExcel_IOFactory', false)) {
	class PHPExcel_IOFactory
	{
		public static function load($file)
		{
			return IOFactory::load($file);
		}
	}
}
