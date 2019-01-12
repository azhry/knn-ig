<?php 
require_once FCPATH . 'libraries/knn/KNearestNeighbor.php';

class Home extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->module = 'home';
	}

	public function index()
	{
		
		exit;

		$this->data['title']	= 'Dashboard';
		$this->data['content']	= 'Dashboard';
		$this->template($this->data, $this->module);
	}

	public function data()
	{
		$this->data['title']	= 'Data';
		$this->data['content']	= 'data';
		$this->template($this->data, $this->module);
	}

	public function analisis()
	{
		$this->data['title']	= 'Analisis';
		$this->data['content']	= 'analisis';
		$this->template($this->data, $this->module);
	}
}