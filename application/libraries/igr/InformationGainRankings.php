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

	public function categoricalDiscretization($arr, $label)
	{
		$globalEntropy 	= $this->calculateEntropy(array_count_values($label));
		$table 			= $this->splitCategory($arr, $label);
		$entropy 		= $this->getEntropyCategory($table);
		$info 			= $this->getInfoCategory($entropy, $arr);
		$gain 			= $globalEntropy - $info;
		return $gain;
	}

	private function splitCategory($arr, $label)
	{
		$possibleValues = array_unique($arr);
		$table = [];
		foreach ($possibleValues as $value)
		{
			foreach ($label as $l)
			{
				$table[$value][$l] = 0;
			}
		}

		foreach ($arr as $i => $v)
		{
			$table[$v][$label[$i]]++;
		}

		return $table;
	}

	private function getEntropyCategory($table)
	{
		$total = 0;
		foreach ($table as $key => $value)
		{
			foreach ($value as $k => $v)
			{
				$total += $v;
			}
		}

		$entropies = [];
		foreach ($table as $key => $value)
		{
			$entropies[$key] = $this->calculateAttributeEntropy(array_values($value));
		}

		return $entropies;
	}

	private function getInfoCategory($entropies, $arr)
	{
		$info 		= 0;
		$arrCount 	= array_count_values($arr);
		$arrSum		= array_sum(array_values($arrCount));
		foreach ($arrCount as $k => $v)
		{
			$info += ($v / $arrSum) * $entropies[$k];
		}
		return $info;
	}

	public function continuousDiscretization($arr, $label)
	{
		$globalEntropy = $this->calculateEntropy(array_count_values($label));
		echo $globalEntropy;
		array_multisort($arr, SORT_DESC, $label);
		$gains = [];
		for ($i = 0; $i < count($arr) - 1; $i++)
		{
			$threshold 					= ($arr[$i] + $arr[$i + 1]) / 2;
			$table 						= $this->split($threshold, $arr, $label);
			$entropy 					= $this->getEntropy($table);
			$info 						= $this->getInfo($entropy, $table);
			$gains[(string)$threshold] 	= $globalEntropy - $info;
		}
		arsort($gains);
		return $gains;
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
		return [
			'greater'	=> $this->calculateAttributeEntropy($table['greater']),
			'less'		=> $this->calculateAttributeEntropy($table['less'])
		];
	}

	private function getInfo($entropies, $table)
	{
		$info 	= 0;
		$sum 	= [
			'greater'	=> array_sum($table['greater']),
			'less'		=> array_sum($table['less'])
		];
		$total 	= array_sum(array_values($sum));
		foreach ($entropies as $key => $entropy)
		{
			$info += ($sum[$key] / $total) * $entropy;
		}
		return $info;
	}

	private function calculateAttributeEntropy($arr)
	{
		$sum = array_sum($arr);
		if ($sum == 0)
		{
			return 0;
		}

		$entropy = 0;
		foreach ($arr as $v)
		{
			$pref = $v / $sum;
			if ($pref != 0)
			{
				$pref *= log($pref);
			}
			else
			{
				$pref = 0;
			}	
			$entropy += $pref;
		}
		return $entropy * -1;
	}

	private function calculateEntropy($labelCount)
	{
		return $this->calculateAttributeEntropy(array_values($labelCount));
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