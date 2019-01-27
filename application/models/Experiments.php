<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Experiments extends Eloquent
{
	protected $table		= 'experiments';
	protected $primaryKey	= 'experiment_id';
}