<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Experiments extends Eloquent
{
	protected $table		= 'experiments';
	protected $primaryKey	= 'experiment_id';

	public function dataset()
	{
		require_once __DIR__ . '/Dataset_type.php';
		return $this->hasOne('Dataset_type', 'id', 'dataset_id');
	}

	public function details()
	{
		require_once __DIR__ . '/Experiment_details.php';
		return $this->hasMany('Experiment_details', 'experiment_id', 'experiment_id');
	}
}