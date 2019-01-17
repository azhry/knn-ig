<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Immunotherapy extends Eloquent
{
	protected $table		= 'immunotherapy';
	protected $primaryKey	= 'patient_id';
	protected $fillable		= ['sex', 'age', 'time', 'number_of_warts', 'type', 'induration_diameter', 'result_of_treatment'];
}