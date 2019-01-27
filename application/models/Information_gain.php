<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Information_gain extends Eloquent
{
	protected $table		= 'information_gain';
	protected $primaryKey	= 'id';
	protected $fillable 	= ['dataset_id', 'feature', 'gain'];
}