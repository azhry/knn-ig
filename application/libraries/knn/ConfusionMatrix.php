<?php 

class ConfusionMatrix
{
	private $actual;
	private $predicted;
	private $confusionMatrix;
	private $classes;

	public function __construct($actual, $predicted, $classes)
	{
		$this->actual 			= $actual;
		$this->predicted 		= $predicted;
		$this->classes 			= $classes;
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
				case $this->classes[0]:
					if ($actual == $this->predicted[$i])
					{
						$matrix['tp']++;
					}
					else
					{
						$matrix['fn']++;
					}
					break;

				case $this->classes[1]:
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
		$denominator = array_sum(array_values($this->confusionMatrix));
		return $denominator == 0 ? 0 : ($this->confusionMatrix['tp'] + $this->confusionMatrix['tn']) / $denominator;
	}

	private function sensitivity()
	{
		return $this->confusionMatrix['tp'] / count(array_diff($this->actual, [$this->classes[1]]));
	}

	private function specificity()
	{
		return $this->confusionMatrix['tn'] / count(array_diff($this->actual, [$this->classes[0]]));
	}
}