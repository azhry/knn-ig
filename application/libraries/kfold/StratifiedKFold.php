<?php 

class StratifiedKFold
{
	private $k;
	private $data;
	private $label;
	private $classDistribution;

	public function __construct($data, $label, $k = 10)
	{
		$this->k 					= $k;
		$this->data 				= $data;
		$this->label 				= $label;
		$this->classDistribution 	= $this->countClassDistribution($this->data);
	}

	private function fold()
	{
		
	}

	private function countClassDistribution($data)
	{
		$classDistribution['total'] = 0;
		foreach ((array)$data as $row)
		{
			$classDistribution['total']++;
			if (isset($classDistribution[$row[$this->label]]))
			{
				$classDistribution[$row[$this->label]]++;	
			}
			else
			{
				$classDistribution[$row[$this->label]] = 1;
			}
		}

		return $classDistribution;
	}
}