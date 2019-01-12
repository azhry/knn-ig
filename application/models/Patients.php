<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Patients extends Eloquent
{
	protected $table		= 'patients';
	protected $primaryKey	= 'patient_id';
}