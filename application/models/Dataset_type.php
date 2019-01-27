<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Dataset_type extends Eloquent
{
	protected $table		= 'dataset_type';
	protected $primaryKey	= 'id';
}