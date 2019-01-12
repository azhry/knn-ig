<?php 

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class SpreadsheetHandler
{
	private $reader;

	public function __construct()
	{
		$this->reader = new Xlsx(); 
	}

	public function read($filepath)
	{
		$spreadsheet = $this->reader->load($filepath);
		var_dump($spreadsheet);
	}
}