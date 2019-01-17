<?php 

class InformationGainRankings
{
	private $criteriaType;
	private $independentVariables;
	private $dependentVariable;
	private $continuousVariables;
	private $categoricalVariables;

	public function __construct()
	{
		
	}

	private function continuousDiscretization($arr, $label)
	{
		array_multisort($arr, SORT_DESC, $label);
		rsort($arr);
		for ($i = 0; $i < count($arr) - 1; $i++)
		{

		}
	}

	private function split($threshold, $arr, $label)
	{
		$table = [
			'greater'	=> [],
			'less'		=> []
		];
		foreach (array_unique($label) as $l)
		{
			$table['greater'][$l] 	= 0;
			$table['less'][$l] 		= 0;
		}

		foreach ($arr as $i => $v)
		{
			if ($v > $threshold)
			{
				$table['greater'][$label[$i]]++;
			}
			else
			{
				$table['less'][$label[$i]]++;
			}
		}

		return $table;
	}

	private function getEntropy($table)
	{

	}

	private function calculateEntropy($labelCount)
	{
		$total 		= array_sum($labelCount);
		$entropy 	= 0;
		foreach ($labelCount as $c)
		{
			$entropy += ($c / $total) * log10($c / $total);
		}
		return $entropy;
	}

	private function categoricalDiscretization($arr, $label)
	{

	}

	public function setCriteriaType($criteriaType)
	{
		$this->criteriaType 		= $criteriaType;
		$this->independentVariables = [];
		$this->continuousVariables	= [];
		$this->categoricalVariables	= [];
		foreach ($this->criteriaType as $key => $value)
		{
			if ($value == 'label')
			{
				$this->dependentVariable = $key;
			}
			else
			{
				$this->independentVariables []= $key;
				if ($value == 'continuous')
				{
					$this->continuousVariables []= $key;
				}
				else if ($value == 'categorical')
				{
					$this->categoricalVariables []= $key;
				}
			}
		}
	}
}