<?php 

class App extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->module = 'home';
	}

	public function index()
	{
		$this->data['title']	= 'Dashboard';
		$this->data['content']	= 'dashboard';
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
			redirect('app/data');
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
			redirect('app/data');
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
			redirect('app/data');
		}

		if ($this->POST('import_gabungan'))
		{
			$this->import('saveToGabungan');
		}

		if ($this->POST('import_immunotherapy'))
		{
			$this->import('saveToImmunotherapy', 'immunotherapy');
		}

		if ($this->POST('import_cyrotherapy'))
		{
			$this->import('saveToCyrotherapy', 'cyrotherapy');
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
		$this->data['content']			= 'data_view';
		$this->template($this->data, $this->module);
	}

	public function experiment_history()
	{
		$this->load->model('Experiments');
		$this->data['experiments'] = Experiments::with('dataset')->orderBy('created_at', 'DESC')->get();
		$this->data['title']	= 'Experiment History';
		$this->data['content']	= 'experiment_history';
		$this->template($this->data, $this->module);	
	}

	public function experiment_details()
	{
		$this->data['experiment_id'] = $this->uri->segment(3);
		if (!isset($this->data['experiment_id']))
		{
			$this->flashmsg('Required param is missing', 'danger');
			redirect('app/experiment-history');
		}
		
		$this->load->model('Experiments');
		$this->data['experiments'] = Experiments::with('dataset', 'details')->find($this->data['experiment_id']);
		if (!isset($this->data['experiments']))
		{
			$this->flashmsg('Experiment not found', 'danger');
			redirect('app/experiment-history');
		}

		$this->data['title']	= 'Experiment Details';
		$this->data['content']	= 'experiment_details';
		$this->template($this->data, $this->module);
	}

	private function import($functionName, $filename = 'import')
	{
		$this->upload($filename, 'data', 'file', '.xlsx');
			
		require_once APPPATH . 'libraries/SpreadsheetHandler.php';
		$excel = new SpreadsheetHandler();
		$sheet = $excel->read(FCPATH . 'data/' . $filename . '.xlsx');
		call_user_func_array([$excel, $functionName], [$sheet]);
		
		$this->flashmsg('New data imported');
		redirect('app/data');
	}

	public function feature_rankings()
	{
		$this->load->model('Information_gain');
		if ($this->POST('update'))
		{
			$this->rankFeatures();
		}

		$this->data['gabungan']			= Information_gain::where('dataset_id', 1)->get();
		$this->data['immunotherapy']	= Information_gain::where('dataset_id', 3)->get();
		$this->data['cyrotherapy']		= Information_gain::where('dataset_id', 2)->get();
		$this->data['title']			= 'Information Gain Rankings';
		$this->data['content']			= 'feature_rankings';
		$this->template($this->data, $this->module);
	}

	private function rankFeatures()
	{
		$this->load->model('Information_gain');
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
		$igr->setCriteriaType([
			'sex'					=> 'categorical',
			'age'					=> 'continuous',
			'time'					=> 'continuous',
			'number_of_warts'		=> 'continuous',
			'type'					=> 'categorical',
			'area'					=> 'continuous',
			'result_of_treatment'	=> 'label',
			'induration_diameter'	=> 'continuous'
		]);
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
		redirect('app/feature-rankings');
	}

	public function analysis()
	{
		if ($this->POST('submit'))
		{
			$clickedButton = $this->POST('method');
			$this->getResults($clickedButton);
		}

		$this->data['knn_results']			= $this->session->userdata('knn_results');
		$this->data['igr_knn_results']		= $this->session->userdata('igr_knn_results');
		$this->data['knn_features']			= $this->session->userdata('knn_features');
		$this->data['igr_knn_features']		= $this->session->userdata('igr_knn_features');
		$this->data['title']				= 'Analysis';
		$this->data['content']				= 'analysis';
		$this->template($this->data, $this->module);
	}

	private function getResults($clickedButton)
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
		$experiment->type = $clickedButton == 'Classify with KNN' ? 'KNN' : 'IGR - KNN';

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
				$classes = [1, 2];
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
				$classes = [1, 0];
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
				$classes = [1, 0];
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
			switch ($clickedButton)
			{
				case 'Classify with KNN':
					$predicted = $knn->predict($fold['test']);
					break;

				case 'Classify with IGR - KNN':
					$predicted = $knn->predict($fold['test'], $ignoredFeatures);
					break;
			}

			$cm = new ConfusionMatrix(array_column($fold['test'], 'result_of_treatment'), $predicted, $classes);
			$result = $cm->classificationReport();
			$end = microtime(true);
			$execution_time = $end - $start;

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
				'execution_time'		=> $execution_time
			];
		}

		switch ($clickedButton)
		{
			case 'Classify with KNN':
				$this->session->set_userdata('knn_results', $experimentDetails);
				$this->session->set_userdata('knn_features', $features);
				$this->session->set_userdata('knn_neighbors', $numberOfNeighbors);
				break;

			case 'Classify with IGR - KNN':
				$this->session->set_userdata('igr_knn_results', $experimentDetails);
				$this->session->set_userdata('igr_knn_features', $selectedFeatures);
				$this->session->set_userdata('igr_knn_neighbors', $numberOfNeighbors);
				break;
		}
		
		Experiment_details::insert($experimentDetails);
		redirect('app/analysis');
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
		redirect('app/data');
	}

	public function clear_result()
	{
		$this->session->sess_destroy();
		redirect('app/analysis');
	}

	public function export()
	{
		$data['contents'] = [
			['content' => [
				['Uji Ke', 'Nilai K', 'Accuracy', 'Specificity', 'Sensitivity', 'Waktu Komputasi']
			]],
			['content' => [
				['Uji Ke', 'Nilai K', 'True Positive', 'True Negative', 'False Positive', 'False Negative', 'Waktu Komputasi']
			]],

			['content' => [
				['Uji Ke', 'Nilai K', 'Accuracy', 'Specificity', 'Sensitivity', 'Waktu Komputasi']
			]],
			['content' => [
				['Uji Ke', 'Nilai K', 'True Positive', 'True Negative', 'False Positive', 'False Negative', 'Waktu Komputasi']
			]]
		];

		$knn_results 		= $this->session->userdata('knn_results');
		$knn_neighbors 		= $this->session->userdata('knn_neighbors');

		$igr_knn_results	= $this->session->userdata('igr_knn_results');
		$igr_knn_neighbors	= $this->session->userdata('igr_knn_neighbors');

		if (isset($knn_results) && isset($igr_knn_results))
		{
			foreach ($knn_results as $i => $row)
			{
				$row = (object)$row;
				$data['contents'][0]['content'] []= [
					$row->fold_number, $knn_neighbors, round($row->accuracy * 100, 2) . '%', round($row->specificity * 100, 2) . '%', round($row->sensitivity * 100, 2) . '%', $row->execution_time
				];

				$data['contents'][1]['content'] []= [
					$row->fold_number, $knn_neighbors, $row->tp, $row->tn, $row->fp, $row->fn, $row->execution_time
				];
			}

			$avg_accuracy 		= array_sum(array_column($knn_results, 'accuracy')) / count($knn_results);
			$avg_specificity 	= array_sum(array_column($knn_results, 'specificity')) / count($knn_results);
			$avg_sensitivity 	= array_sum(array_column($knn_results, 'sensitivity')) / count($knn_results);
			$avg_execution_time = array_sum(array_column($knn_results, 'execution_time')) / count($knn_results);
			$data['contents'][0]['content'] []= [
				'Rata-rata', $knn_neighbors, round($avg_accuracy * 100, 2) . '%', round($avg_specificity * 100, 2) . '%', round($avg_sensitivity * 100, 2) . '%', $avg_execution_time
			];

			$avg_tp 	= array_sum(array_column($knn_results, 'tp')) / count($knn_results);
			$avg_tn 	= array_sum(array_column($knn_results, 'tn')) / count($knn_results);
			$avg_fp 	= array_sum(array_column($knn_results, 'fp')) / count($knn_results);
			$avg_fn 	= array_sum(array_column($knn_results, 'fn')) / count($knn_results);
			$data['contents'][1]['content'] []= [
				'Rata-rata', $knn_neighbors, $avg_tp, $avg_tn, $avg_fp, $avg_fn, $avg_execution_time
			];

			foreach ($igr_knn_results as $i => $row)
			{
				$row = (object)$row;
				$data['contents'][2]['content'] []= [
					$row->fold_number, $igr_knn_neighbors, round($row->accuracy * 100, 2) . '%', round($row->specificity * 100, 2) . '%', round($row->sensitivity * 100, 2) . '%', $row->execution_time
				];

				$data['contents'][3]['content'] []= [
					$row->fold_number, $igr_knn_neighbors, $row->tp, $row->tn, $row->fp, $row->fn, $row->execution_time
				];
			}

			$avg_accuracy 		= array_sum(array_column($igr_knn_results, 'accuracy')) / count($igr_knn_results);
			$avg_specificity 	= array_sum(array_column($igr_knn_results, 'specificity')) / count($igr_knn_results);
			$avg_sensitivity 	= array_sum(array_column($igr_knn_results, 'sensitivity')) / count($igr_knn_results);
			$avg_execution_time = array_sum(array_column($igr_knn_results, 'execution_time')) / count($igr_knn_results);
			$data['contents'][2]['content'] []= [
				'Rata-rata', $igr_knn_neighbors, round($avg_accuracy * 100, 2) . '%', round($avg_specificity * 100, 2) . '%', round($avg_sensitivity * 100, 2) . '%', $avg_execution_time
			];

			$avg_tp 	= array_sum(array_column($igr_knn_results, 'tp')) / count($igr_knn_results);
			$avg_tn 	= array_sum(array_column($igr_knn_results, 'tn')) / count($igr_knn_results);
			$avg_fp 	= array_sum(array_column($igr_knn_results, 'fp')) / count($igr_knn_results);
			$avg_fn 	= array_sum(array_column($igr_knn_results, 'fn')) / count($igr_knn_results);
			$data['contents'][3]['content'] []= [
				'Rata-rata', $igr_knn_neighbors, $avg_tp, $avg_tn, $avg_fp, $avg_fn, $avg_execution_time
			];

			require_once APPPATH . 'libraries/SpreadsheetHandler.php';
			$excel = new SpreadsheetHandler();
			$excel->write($data);
		}
	}
}