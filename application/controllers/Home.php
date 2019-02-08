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

			$this->load->model('Immunotherapy');
			$immunotherapy = Immunotherapy::get();
			$result = $spreadsheet->fitData($immunotherapy, ['patient_id', 'created_at', 'updated_at']);
			$data 	= $result['dataset'];
			$actual = $result['actual'];

			$ranks 		= $igr->rankFeatures($data, $actual);
			$datasetId 	= 3;
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

			$this->flashmsg('Features ranked');
			redirect('home/feature-rankings');
		}

		$this->data['gabungan']			= Information_gain::where('dataset_id', 1)->get();
		$this->data['immunotherapy']	= Information_gain::where('dataset_id', 2)->get();
		$this->data['cyrotherapy']		= Information_gain::where('dataset_id', 3)->get();
		$this->data['title']			= 'Information Gain Rankings';
		$this->data['content']			= 'feature_rankings';
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
			require_once APPPATH . 'libraries/SpreadsheetHandler.php';

			$type 				= $this->POST('type');
			$numberOfFolds 		= $this->POST('k');
			$threshold			= $this->POST('threshold');
			$numberOfNeighbors	= $this->POST('number_of_neighbors');

			$this->load->model('Experiments');
			$this->load->model('Experiment_details');
			$this->load->model('Information_gain');

			$experiment = new Experiments();
			$experiment->number_of_folds = $numberOfFolds;
			$experiment->thresholds = $threshold;
			$experiment->number_of_neighbors = $numberOfNeighbors;

			$knn = new KNearestNeighbor($numberOfNeighbors);
			$attributes = [
				'sex'					=> 'categorical',
				'age'					=> 'continuous',
				'time'					=> 'continuous',
				'number_of_warts'		=> 'continuous',
				'type'					=> 'categorical',
				'area'					=> 'continuous',
				'result_of_treatment'	=> 'label'
			];

			switch ($type)
			{
				case 'Gabungan':
					$experiment->dataset_id = 1;
					$features 			= Information_gain::where('dataset_id', 1)
											->get();
					$selectedFeatures 	= Information_gain::where('dataset_id', 1)
											->where('gain', '>=', $threshold)
											->get();
					$features 			= array_column($features->toArray(), 'feature');
					$selectedFeatures	= array_column($selectedFeatures->toArray(), 'feature');
					$ignoredFeatures 	= array_diff($features, $selectedFeatures);

					$this->load->model('Patients');
					$data = Patients::get();
					break;

				case 'Immunotherapy':
					$attributes['induration_diameter'] = 'continuous';
					$experiment->dataset_id = 3;
					$features 			= Information_gain::where('dataset_id', 3)
											->get();
					$selectedFeatures 	= Information_gain::where('dataset_id', 3)
											->where('gain', '>=', $threshold)
											->get();
					$features 			= array_column($features->toArray(), 'feature');
					$selectedFeatures	= array_column($selectedFeatures->toArray(), 'feature');
					$ignoredFeatures 	= array_diff($features, $selectedFeatures);

					$this->load->model('Immunotherapy');
					$data = Immunotherapy::get();
					break;

				case 'Cyrotherapy':
					$experiment->dataset_id = 2;
					$features 			= Information_gain::where('dataset_id', 2)
											->get();
					$selectedFeatures 	= Information_gain::where('dataset_id', 2)
											->where('gain', '>=', $threshold)
											->get();
					$features 			= array_column($features->toArray(), 'feature');
					$selectedFeatures	= array_column($selectedFeatures->toArray(), 'feature');
					$ignoredFeatures 	= array_diff($features, $selectedFeatures);

					$this->load->model('Cyrotherapy');
					$data = Cyrotherapy::get();
					break;
			}

			$experiment->save();

			$knn->setCriteriaType($attributes);

			$spreadsheet = new SpreadsheetHandler();
			$result = $spreadsheet->fitData($data, ['patient_id', 'created_at', 'updated_at']);
			$data 	= $result['dataset'];

			$experimentDetails = [];

			$kf = new StratifiedKFold($data, 'result_of_treatment');
			foreach ($kf->folds() as $i => $fold)
			{
				$start = microtime(true);
				$knn->fit($fold['train']);
				$predicted = $knn->predict($fold['test']);
				$cm = new ConfusionMatrix(array_column($fold['test'], 'result_of_treatment'), $predicted);
				$result = $cm->classificationReport();
				$end = microtime(true);
				$execution_time = $end - $start;

				$start = microtime(true);
				$knn->fit($fold['train'], $ignoredFeatures);
				$predicted = $knn->predict($fold['test']);
				$cm = new ConfusionMatrix(array_column($fold['test'], 'result_of_treatment'), $predicted);
				$result_igr = $cm->classificationReport();
				$end = microtime(true);
				$igr_execution_time = $end - $start;

				$experimentDetails []= [
					'experiment_id'			=> $experiment->experiment_id,
					'fold_number'			=> $i + 1,
					'tp'					=> $result['matrix']['tp'],
					'tn'					=> $result['matrix']['tn'],
					'fp'					=> $result['matrix']['fp'],
					'fn'					=> $result['matrix']['fn'],
					'accuracy'				=> $result['accuracy'],
					'sensitivity'			=> $result['sensitivity'],
					'specificity'			=> $result['specificity'],
					'execution_time'		=> $execution_time,
					'igr_tp'				=> $result_igr['matrix']['tp'],
					'igr_tn'				=> $result_igr['matrix']['tn'],
					'igr_fp'				=> $result_igr['matrix']['fp'],
					'igr_fn'				=> $result_igr['matrix']['fn'],
					'igr_accuracy'			=> $result_igr['accuracy'],
					'igr_sensitivity'		=> $result_igr['sensitivity'],
					'igr_specificity'		=> $result_igr['specificity'],
					'igr_execution_time'	=> $igr_execution_time
				];
			}

			$this->session->set_userdata('experiment_results', $experimentDetails);
			$this->session->set_userdata('features', [
				'features'			=> $features,
				'selected_features'	=> $selectedFeatures
			]);
			Experiment_details::insert($experimentDetails);
			redirect('home/analysis');
		}

		$this->data['experiment_results']	= $this->session->userdata('experiment_results');
		$this->data['features']				= $this->session->userdata('features');
		$this->data['title']				= 'Analysis';
		$this->data['content']				= 'analysis';
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