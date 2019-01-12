<?php 
require_once APPPATH . 'libraries/SpreadsheetHandler.php';
require_once APPPATH . 'libraries/knn/KNearestNeighbor.php';

class Home extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->module = 'home';
	}

	public function index()
	{
		$excel = new SpreadsheetHandler();
		$excel->read(FCPATH . 'data/Gabungan.xlsx');
		exit;
		$this->data['title']	= 'Dashboard';
		$this->data['content']	= 'Dashboard';
		$this->template($this->data, $this->module);
	}

	public function data()
	{
		$this->load->model('Patients');
		if ($this->POST('submit'))
		{
			$patient = new Patients();
			$patient->sex 					= $this->POST('sex');
			$patient->age 					= $this->POST('age');
			$patient->time 					= $this->POST('time');
			$patient->number_of_warts 		= $this->POST('number_of_warts');
			$patient->type 					= $this->POST('type');
			$patient->area 					= $this->POST('area');
			$patient->result_of_treatment 	= $this->POST('result_of_treatment');
			$patient->save();

			$this->flashmsg('New patient added');
			redirect('home/data');
		}

		if ($this->POST('delete'))
		{
			$patient = Patients::find($this->POST('patient_id'));
			echo json_encode($patient);
			$patient->delete();
			exit;
		}

		if ($this->POST('edit'))
		{
			$patient = Patients::find($this->POST('patient_id'));
			$patient->sex 					= $this->POST('sex');
			$patient->age 					= $this->POST('age');
			$patient->time 					= $this->POST('time');
			$patient->number_of_warts 		= $this->POST('number_of_warts');
			$patient->type 					= $this->POST('type');
			$patient->area 					= $this->POST('area');
			$patient->result_of_treatment 	= $this->POST('result_of_treatment');
			$patient->save();

			echo json_encode($patient);
			exit;
		}

		$this->data['data']		= Patients::get();
		$this->data['title']	= 'Data';
		$this->data['content']	= 'data';
		$this->template($this->data, $this->module);
	}

	public function analysis()
	{
		$this->data['title']	= 'Analysis';
		$this->data['content']	= 'analysis';
		$this->template($this->data, $this->module);
	}
}