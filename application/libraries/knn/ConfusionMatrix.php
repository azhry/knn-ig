<?php 

class ConfusionMatrix
{
	private $actual;
	private $predicted;
	private $confusionMatrix;

	public function __construct($actual, $predicted)
	{
		$this->actual 			= $actual;
		$this->predicted 		= $predicted;
		$this->confusionMatrix 	= $this->matrix();
	}

	public function classificationReport()
	{
		return [
			'matrix'		=> $this->confusionMatrix,
			'accuracy'		=> $this->accuracy(),
			'sensitivity'	=> $this->sensitivity(),
			'specificity'	=> $this->specificity()
		];
	}

	private function matrix()
	{
		$matrix = [
			'tp'	=> 0,
			'tn'	=> 0,
			'fp'	=> 0,
			'fn'	=> 0
		];
		foreach ($this->actual as $i => $actual)
		{
			switch ($actual)
			{
				case 1:
					if ($actual == $this->predicted[$i])
					{
						$matrix['tp']++;
					}
					else
					{
						$matrix['fn']++;
					}
					break;

				case 2:
					if ($actual == $this->predicted[$i])
					{
						$matrix['tn']++;
					}
					else
					{
						$matrix['fp']++;
					}
					break;
			}
		}

		return $matrix;
	}

	private function accuracy()
	{
		return ($this->confusionMatrix['tp'] + $this->confusionMatrix['tn']) / array_sum(array_values($this->confusionMatrix));
	}

	private function sensitivity()
	{
		return $this->confusionMatrix['tp'] / count(array_diff($this->actual, [2]));
	}

	private function specificity()
	{
		return $this->confusionMatrix['tn'] / count(array_diff($this->actual, [1]));
	}
}