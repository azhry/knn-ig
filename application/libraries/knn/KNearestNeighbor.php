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
	private $values;
	private $labels;

	public function __construct($k = 1)
	{
		$this->k = $k;
	}

	public function fit($data)
	{
		$this->values 	= [];
		$this->labels 	= [];
		$this->data 	= (array)$data;
		foreach ($this->data as $row)
		{
			$values = [];
			foreach ($row as $key => $value)
			{
				if ($this->criteriaType[$key] == 'label')
				{
					$this->labels []= $value;
				}
				else
				{
					$values[$key] = $value;
				}
			}
			$this->values []= $values;
		}
	}

	public function predict($data)
	{

	}

	public function continuousDistance($x, $y)
	{
		$it = new MultipleIterator();
		$it->attachIterator(new ArrayIterator($x));
		$it->attachIterator(new ArrayIterator($y));

		$sum = 0;
		foreach ($it as $values)
		{
			$sum += pow($values[0] - $values[1], 2);
		}

		return sqrt($sum);
	}

	public function categoricalDistance()
	{

	}

	public function tabulateCategory($key)
	{
		$values = array_column($this->values, $key);
		$labels = $this->labels;
		$it = new MultipleIterator();
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