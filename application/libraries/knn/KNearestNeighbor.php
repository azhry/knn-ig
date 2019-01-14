<?php 

class KNearestNeighbor
{
	private $k;
	private $criteriaType;
	private $independentVariables;
	private $dependentVariable;
	private $continuousVariables;
	private $categoricalVariables;
	private $data;
	private $samples;
	private $labels;
	private $excludeKeys;

	public function __construct($k = 1)
	{
		$this->k = $k;
	}

	public function fit($data, $excludeKeys = [])
	{
		$this->excludeKeys 	= $excludeKeys;
		$this->samples 		= [];
		$this->labels 		= [];
		$this->data 		= (array)$data;
		foreach ($this->data as $row)
		{
			$values = [];
			foreach ($row as $key => $value)
			{
				if (in_array($key, $excludeKeys))
				{
					continue;
				}
				
				if ($this->criteriaType[$key] == 'label')
				{
					$this->labels []= $value;
				}
				else
				{
					$values[$key] = $value;
				}
			}
			$this->samples []= $values;
		}
	}

	public function predict($data)
	{
		$result 	= [];
		foreach ($data as $row)
		{
			$distances	= [];
			$record 	= [];
			foreach ($row as $key => $value)
			{
				if (in_array($key, $this->excludeKeys) or $key == $this->dependentVariable)
				{
					continue;
				}

				$record[$key] = $value;
			}

			foreach ($record as $key => $value)
			{
				$targetContinuous	= [];
				$targetCategorical 	= [];
				if (in_array($key, $this->continuousVariables))
				{
					$targetContinuous []= $value;
				}
				else
				{
					$targetCategorical []= $value;
				}
			}

			foreach ($this->samples as $sample)
			{
				foreach ($sample as $key => $value)
				{
					$sampleContinuous	= [];
					$sampleCategorical 	= [];
					if (in_array($key, $this->continuousVariables))
					{
						$sampleContinuous []= $value;
					}
					else
					{
						$sampleCategorical []= $value;
					}
				}

				$distances []= $this->continuousDistance($targetContinuous, $sampleContinuous) + $this->categoricalDistance($targetCategorical, $sampleCategorical);
			}

			$labels 	= $this->labels;
			$predicted 	= [];
			array_multisort($distances, SORT_ASC, $labels);
			for ($i = 0; $i < $this->k; $i++)
			{
				if (!isset($predicted[$labels[$i]]))
				{
					$predicted[$labels[$i]] = 1;	
				}
				else
				{
					$predicted[$labels[$i]]++;
				}
			}
			$predicted = array_keys($predicted);
			$result []= $predicted[0];
		}
		return $result;
	}

	private function continuousDistance($x, $y)
	{
		if (count($x) !== count($y))
		{
			throw new InvalidArgumentException('Size of given arrays does not match');
		}

		$sum = 0;
		foreach ($x as $i => $val)
		{
			$sum += ($val - $y[$i]) ** 2;
		}

		return sqrt((float)$sum);
	}

	private function categoricalDistance($x, $y)
	{
		if (count($x) !== count($y))
		{
			throw new InvalidArgumentException('Size of given arrays does not match');
		}

		$sum = 0;
		foreach ($x as $i => $val)
		{
			$sum += $this->calculateCategoricalDistance($val, $y[$i]) ** 2;
		}

		return sqrt((float)$sum);
	}

	private function calculateCategoricalDistance($xv, $yv)
	{
		$table 	= $this->tabulateCategory($key);
		$result = 0;
		$it 	= new MultipleIterator();
		$it->attachIterator(new ArrayIterator($table[$xv]));
		$it->attachIterator(new ArrayIterator($table[$yv]));
		foreach ($it as $v)
		{
			$result += abs(($v[0] / array_sum($table[$xv])) - ($v[1] / array_sum($table[$yv])));
		}

		return $result;
	}

	private function tabulateCategory($key)
	{
		$values = array_column($this->samples, $key);
		$labels = $this->labels;
		$it 	= new MultipleIterator();
		$it->attachIterator(new ArrayIterator($values));
		$it->attachIterator(new ArrayIterator($labels));
		$table = [];
		foreach ($it as $v)
		{
			if (!isset($table[$v[0]][$v[1]]))
			{
				$table[$v[0]][$v[1]] = 1;	
			}
			else
			{
				$table[$v[0]][$v[1]]++;
			}
		}

		return $table;
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