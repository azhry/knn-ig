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

	public function folds()
	{
		$folds = [];
		$splits = $this->splits();

		foreach ($splits as $i => $split)
		{
			$test = $split;
			$train = [];
			for ($j = 0; $j < count($splits); $j++)
			{
				if ($j == $i)
				{
					continue;
				}
				
				foreach ($splits[$j] as $row)
				{
					$train []= $row;
				}
			}

			$folds []= [
				'test'	=> $split,
				'train'	=> $train
			];
		}

		return $folds;
	}

	private function splits()
	{
		shuffle($this->data);
		$folds = [];
		for ($i = 0; $i < $this->k; $i++)
		{
			$folds[$i] = [];
			$labels = array_diff(array_keys($this->classDistribution), ['total']);
			$labels = array_combine($labels, array_fill(0, count($labels), 0));
			for ($j = 0; $j < count($this->data); $j++)
			{
				if ($labels[$this->data[$j][$this->label]] >= $this->classDistribution[$this->data[$j][$this->label]] / $this->k)
				{
					continue;
				}
				if (count($folds[$i]) >= $this->classDistribution['total'] / $this->k)
				{
					break;
				}
				$folds[$i] []= $this->data[$j];
				$labels[$this->data[$j][$this->label]]++;
				unset($this->data[$j]);
			}
			
			// re-index data
			$this->data = array_values($this->data);
		}

		foreach ($this->data as $data)
		{
			$folds[$this->k - 1] []= $data;
		}
		return $folds;
	}

	private function countClassDistribution($data)
	{
		$classDistribution['total'] = 0;
		foreach ($data as $row)
		{
			$row = (array)$row;
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