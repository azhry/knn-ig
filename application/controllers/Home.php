<?php 

class Home extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->module = 'home';
	}

	public function index()
	{
		// $this->load->model('Patients');
		// $patients = Patients::get();
		// $data 	= [];
		// $actual = [];
		// foreach ($patients as $patient)
		// {
		// 	$data []= [
		// 		'patient_id'			=> $patient['patient_id'],
		// 		'sex'					=> $patient['sex'],
		// 		'age'					=> $patient['age'],
		// 		'time'					=> $patient['time'],
		// 		'number_of_warts'		=> $patient['number_of_warts'],
		// 		'type'					=> $patient['type'],
		// 		'area'					=> $patient['area'],
		// 		'result_of_treatment'	=> $patient['result_of_treatment']
		// 	];

		// 	$actual []= $patient['result_of_treatment'];
		// }

		// $knn = new KNearestNeighbor();
		// $knn->setCriteriaType([
		// 	'sex'					=> 'categorical',
		// 	'age'					=> 'continuous',
		// 	'time'					=> 'continuous',
		// 	'number_of_warts'		=> 'continuous',
		// 	'type'					=> 'categorical',
		// 	'area'					=> 'continuous',
		// 	'result_of_treatment'	=> 'label'
		// ]);
		// $knn->fit($data, ['patient_id']);
		// $predicted = $knn->predict($data);
		// $cm = new ConfusionMatrix($actual, $predicted);
		// var_dump($cm->classificationReport());
		// $kfold = new StratifiedKFold($data, 'result_of_treatment');
		// $kfold->folds();
		// exit;

		// require_once APPPATH . 'libraries/igr/InformationGainRankings.php';
		// $igr = new InformationGainRankings();
		// $igr->setCriteriaType([
		// 	'sex'					=> 'categorical',
		// 	'age'					=> 'continuous',
		// 	'time'					=> 'continuous',
		// 	'number_of_warts'		=> 'continuous',
		// 	'type'					=> 'categorical',
		// 	'area'					=> 'continuous',
		// 	'result_of_treatment'	=> 'label'
		// ]);
		// $igr->categoricalDiscretization(array_column($data, 'type'), $actual);
		// $igr->continuousDiscretization(array_column($data, 'time'), $actual);

		// exit;

		$this->data['title']	= 'Dashboard';
		$this->data['content']	= 'Dashboard';
		$this->template($this->data, $this->module);
	}

	public function data()
	{
		$this->load->model('Patients');
		$this->load->model('Immunotherapy');
		$this->load->model('Cyrotherapy');

		if ($this->POST('submit_gabungan'))
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

		if ($this->POST('submit_immunotherapy'))
		{
			$patient = new Immunotherapy();
			$patient->sex 					= $this->POST('sex');
			$patient->age 					= $this->POST('age');
			$patient->time 					= $this->POST('time');
			$patient->number_of_warts 		= $this->POST('number_of_warts');
			$patient->type 					= $this->POST('type');
			$patient->area 					= $this->POST('area');
			$patient->induration_diameter	= $this->POST('induration_diameter');
			$patient->result_of_treatment 	= $this->POST('result_of_treatment');
			$patient->save();

			$this->flashmsg('New patient added');
			redirect('home/data');
		}

		if ($this->POST('submit_cyrotherapy'))
		{
			$patient = new Cyrotherapy();
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

		if ($this->POST('import_gabungan'))
		{
			$this->upload('import', 'data', 'file', '.xlsx');
			
			require_once APPPATH . 'libraries/SpreadsheetHandler.php';
			$excel = new SpreadsheetHandler();
			$sheet = $excel->read(FCPATH . 'data/import.xlsx');
			$excel->saveToGabungan($sheet);
			
			$this->flashmsg('New data imported');
			redirect('home/data');
		}

		if ($this->POST('import_immunotherapy'))
		{
			$this->upload('import', 'data', 'file', '.xlsx');
			
			require_once APPPATH . 'libraries/SpreadsheetHandler.php';
			$excel = new SpreadsheetHandler();
			$sheet = $excel->read(FCPATH . 'data/import.xlsx');
			$excel->saveToImmunotherapy($sheet);
			
			$this->flashmsg('New data imported');
			redirect('home/data');
		}

		if ($this->POST('import_cyrotherapy'))
		{
			$this->upload('import', 'data', 'file', '.xlsx');
			
			require_once APPPATH . 'libraries/SpreadsheetHandler.php';
			$excel = new SpreadsheetHandler();
			$sheet = $excel->read(FCPATH . 'data/import.xlsx');
			$excel->saveToCyrotherapy($sheet);
			
			$this->flashmsg('New data imported');
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

		$this->data['patients']			= Patients::get();
		$this->data['immunotherapy']	= Immunotherapy::get();
		$this->data['cyrotherapy']		= Cyrotherapy::get();
		$this->data['title']			= 'Data';
		$this->data['content']			= 'data';
		$this->template($this->data, $this->module);
	}

	public function feature_rankings()
	{
		$this->load->model('Information_gain');
		if ($this->POST('update'))
		{
			Information_gain::truncate();
			
			require_once APPPATH . 'libraries/SpreadsheetHandler.php';
			require_once APPPATH . 'libraries/igr/InformationGainRankings.php';

			$this->load->model('Patients');
			$patients = Patients::get();

			$spreadsheet = new SpreadsheetHandler();
			$result = $spreadsheet->fitData($patients, ['patient_id', 'created_at', 'updated_at']);
			$data 	= $result['dataset'];
			$actual = $result['actual'];

			$igr = new InformationGainRankings();
			$igr->setCriteriaType([
				'sex'					=> 'categorical',
				'age'					=> 'continuous',
				'time'					=> 'continuous',
				'number_of_warts'		=> 'continuous',
				'type'					=> 'categorical',
				'area'					=> 'continuous',
				'result_of_treatment'	=> 'label'
			]);
			$ranks 		= $igr->rankFeatures($data, $actual);
			$datasetId 	= 1;
			$data 		= [];
			foreach ($ranks as $key => $value)
			{
				$data []= [
					'dataset_id'	=> $datasetId,
					'feature'		=> $key,
					'gain'			=> $value
				];
			}
			Information_gain::insert($data);

			$this->load->model('Cyrotherapy');
			$cyrotherapy = Cyrotherapy::get();
			$result = $spreadsheet->fitData($cyrotherapy, ['patient_id', 'created_at', 'updated_at']);
			$data 	= $result['dataset'];
			$actual = $result['actual'];

			$ranks 		= $igr->rankFeatures($data, $actual);
			$datasetId 	= 2;
			$data 		= [];
			foreach ($ranks as $key => $value)
			{
				$data []= [
					'dataset_id'	=> $datasetId,
					'feature'		=> $key,
					'gain'			=> $value
				];
			}
			Information_gain::insert($data);

			var_dump($ranks);
			exit;
		}

		$this->data['info_gain']	= Information_gain::get();
		$this->data['title']		= 'Information Gain Rankings';
		$this->data['content']		= 'feature_rankings';
		$this->template($this->data, $this->module);
	}

	public function analysis()
	{
		if ($this->POST('submit'))
		{
			// set max_execution_time to infinity
			ini_set('max_execution_time', 0);

			require_once APPPATH . 'libraries/knn/KNearestNeighbor.php';
			require_once APPPATH . 'libraries/knn/ConfusionMatrix.php';
			require_once APPPATH . 'libraries/kfold/StratifiedKFold.php';

			$this->load->model('Patients');
			$patients = Patients::get();
			$data 	= [];
			$actual = [];
			foreach ($patients as $patient)
			{
				$data []= [
					'patient_id'			=> $patient['patient_id'],
					'sex'					=> $patient['sex'],
					'age'					=> $patient['age'],
					'time'					=> $patient['time'],
					'number_of_warts'		=> $patient['number_of_warts'],
					'type'					=> $patient['type'],
					'area'					=> $patient['area'],
					'result_of_treatment'	=> $patient['result_of_treatment']
				];

				$actual []= $patient['result_of_treatment'];
			}

			// TODO
			
			redirect('home/analysis');
		}

		$this->data['title']	= 'Analysis';
		$this->data['content']	= 'analysis';
		$this->template($this->data, $this->module);
	}

	public function clear_data()
	{
		$this->load->model('Patients');
		$this->load->model('Immunotherapy');
		$this->load->model('Cyrotherapy');
		Patients::truncate();
		Immunotherapy::truncate();
		Cyrotherapy::truncate();
		$this->flashmsg('Data cleared');
		redirect('home/data');
	}

	public function clear_result()
	{
		$this->session->sess_destroy();
		redirect('home/analysis');
	}
}