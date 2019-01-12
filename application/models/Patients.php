<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Attendances extends Eloquent
{
	protected $table		= 'patients';
	protected $primaryKey	= 'patient_id';
}