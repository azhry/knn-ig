<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Cyrotherapy extends Eloquent
{
	protected $table		= 'cyrotherapy';
	protected $primaryKey	= 'patient_id';
	protected $fillable		= ['sex', 'age', 'time', 'number_of_warts', 'type', 'result_of_treatment'];
}