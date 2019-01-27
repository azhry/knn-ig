<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Experiment_details extends Eloquent
{
	protected $table		= 'experiment_details';
	protected $primaryKey	= 'detail_id';
	protected $fillable		= ['experiment_id', 'fold_number', 'tp', 'tn', 'fp', 'fn', 'accuracy', 'sensitivity', 'specificity'];
}