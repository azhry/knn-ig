<?php 

defined('START_UPPER') or define('START_UPPER', 65);
defined('END_UPPER') or define('END_UPPER', 90);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

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

	public function write($data, $filename = 'export.xlsx')
	{
		$spreadsheet = new Spreadsheet();
		$writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

		for ($i = 0; $i < count($data['contents']) - 1; $i++)
		{
			$spreadsheet->createSheet();
		}
		
		for ($k = 0; $k < count($data['contents']); $k++)
		{
			$spreadsheet->setActiveSheetIndex($k);
			$activeSheet = $spreadsheet->getActiveSheet();
			foreach ($data['contents'][$k]['content'] as $i => $row)
			{
				foreach ($row as $j => $cell)
				{
					$activeSheet->setCellValue(chr(START_UPPER + $j) . ($i + 1), $cell);
					$activeSheet->getStyle(chr(START_UPPER + $j) . ($i + 1))->applyFromArray([
						'font' => [
							'size'	=> 12,
							'name'	=> 'Times New Roman'
						]
					]);
				}
			}	
		}
		

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'"'); 
		header('Cache-Control: max-age=0');
		$writer->save('php://output', 'xlsx');
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