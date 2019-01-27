<?php 

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class SpreadsheetHandler
{
	private $reader;
	private $CI;

	public function __construct()
	{
		$this->reader = new Xlsx(); 
		$this->CI =& get_instance();
	}

	public function fitData($data, $excludeKey = [])
	{
		$dataset 	= [];
		$actual 	= [];
		foreach ($data as $row)
		{
			$record = [];
			foreach ($row->toArray() as $key => $value)
			{
				if (!in_array($key, $excludeKey))
				{
					$record[$key] = $value;
				}
			}
			$dataset 	[]= $record;
			$actual 	[]= $row['result_of_treatment'];
		}

		return [
			'dataset'	=> $dataset,
			'actual'	=> $actual
		];
	}

	public function read($filepath)
	{
		$spreadsheet 	= $this->reader->load($filepath);
		$sheet 			= $spreadsheet->getActiveSheet();
		return $sheet;
	}

	public function saveToGabungan($sheet)
	{
		$data = $this->serialize($sheet);
		$this->CI->load->model('Patients');
		Patients::insert($data);
	}

	public function saveToImmunotherapy($sheet)
	{
		$data = $this->serialize($sheet);
		$this->CI->load->model('Immunotherapy');
		Immunotherapy::insert($data);
	}

	public function saveToCyrotherapy($sheet)
	{
		$data = $this->serialize($sheet);
		$this->CI->load->model('Cyrotherapy');
		Cyrotherapy::insert($data);
	}

	private function serialize($sheet)
	{
		$data 		= [];
		$columns 	= [];
		foreach ($sheet->getRowIterator() as $i => $row)
		{
			if ($i == 0)
			{
				continue;
			}

			$cellIterator 	= $row->getCellIterator();
			$record 		= [];
			$j = 0;
			foreach ($cellIterator as $cell)
			{
				if ($i == 1)
				{
					$columns []= $cell->getValue();
				}
				else
				{
					$record[$columns[$j]] = $cell->getValue();
				}
				$j++;
			}

			if ($i > 1)
			{
				$data []= $record;
			}
		}

		return $data;
	}
}