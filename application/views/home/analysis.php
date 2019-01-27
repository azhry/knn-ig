<div class="page-content">
	<?= $this->session->flashdata('msg') ?>
	<!-- BEGIN PAGE CONTENT INNER -->
	<div class="row margin-top-10">
		<div class="col-md-12">
			<!-- <div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">IGR</div>
				</div>
				<div class="portlet-body">
					<?= form_open('home/analysis') ?>
					<div class="form-group">
						<label for="type">Type</label>
						<select required class="form-control" name="type">
							<option value="">Choose Type</option>
							<option value="Gabungan">Gabungan</option>
							<option value="Immunotherapy">Immunotherapy</option>
							<option value="Cyrotherapy">Cyrotherapy</option>
						</select>
					</div>
					<div class="form-group">
						<input type="submit" name="submit" value="Get Result" class="btn blue">
					</div>
					<?= form_close() ?>
				</div>
			</div> -->
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">Get Result</div>
				</div>
				<div class="portlet-body">
					<?= form_open('home/analysis') ?>
					<div class="form-group">
						<label for="threshold">Threshold</label>
						<input class="form-control" type="number" step="any" name="threshold">
					</div>
					<div class="form-group">
						<label for="k">Number of Fold</label>
						<input class="form-control" type="number" value="10" min="1" name="k">
					</div>
					<div class="form-group">
						<label for="number_of_neighbors">Number of Neighbors</label>
						<input class="form-control" type="number" min="1" value="1" step="2" name="number_of_neighbors">
					</div>
					<div class="form-group">
						<label for="type">Type</label>
						<select required class="form-control" name="type">
							<option value="">Choose Type</option>
							<option value="Gabungan">Gabungan</option>
							<option value="Immunotherapy">Immunotherapy</option>
							<option value="Cyrotherapy">Cyrotherapy</option>
						</select>
					</div>
					<div class="form-group">
						<input type="submit" name="submit" value="Get Result" class="btn blue">
					</div>
					<?= form_close() ?>
				</div>
			</div>
			<!-- <div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">Test Data</div>
				</div>
				<div class="portlet-body">
					<?= form_open('home/analysis') ?>
					<div class="form-group">
						<label for="sex">Sex</label>
						<select required class="form-control" name="sex">
							<option value="">Choose Sex</option>
							<option value="1">Male</option>
							<option value="2">Female</option>
						</select>
					</div>
					<div class="form-group">
						<label for="age">Age</label>
						<input type="number" name="age" class="form-control" min="0">
					</div>
					<div class="form-group">
						<label for="time">Time</label>
						<input type="number" step="any" name="time" class="form-control">
					</div>
					<div class="form-group">
						<label for="number_of_warts">Number of Warts</label>
						<input type="number" name="number_of_warts" class="form-control">
					</div>
					<div class="form-group">
						<label for="type">Type</label>
						<input type="number" name="type" class="form-control">
					</div>
					<div class="form-group">
						<label for="area">Area</label>
						<input type="number" name="area" class="form-control">
					</div>
					<div class="form-group">
						<label for="threshold">Threshold</label>
						<input class="form-control" type="number" step="any" name="threshold">
					</div>
					<div class="form-group">
						<label for="k">K</label>
						<input class="form-control" type="number" min="1" name="k">
					</div>
					<div class="form-group">
						<label for="number_of_neighbors">Number of Neighbors</label>
						<input class="form-control" type="number" min="1" value="1" step="2" name="number_of_neighbors">
					</div>
					<div class="form-group">
						<input type="submit" name="classify" value="Classify" class="btn blue">
					</div>
					<?= form_close() ?>
				</div>
			</div> -->
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- <div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Summary
					</div>
					<div class="caption pull-right">
						<a href="<?= base_url('home/clear-result') ?>" class="btn blue btn-xs">
							Clear Result
						</a>
					</div>
				</div>
				<div class="portlet-body" height="300">
					<canvas id="result-chart"></canvas>
				</div>
			</div> -->
			<!-- <div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Result per fold
					</div>
				</div>
				<div class="portlet-body" height="300">
					<canvas id="fold-chart"></canvas>
				</div>
			</div> -->
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Performance
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
								<th style="vertical-align: middle; width: 30px;" rowspan="2">Fold Number</th>
								<th class="text-center" colspan="8">KNN</th>
								<th class="text-center" colspan="8">IGR - KNN</th>
							</tr>
							<tr>
								<th>Execution Time (s)</th>
								<th>TP</th>
								<th>TN</th>
								<th>FP</th>
								<th>FN</th>
								<th>Accuracy</th>
								<th>Sensitivity</th>
								<th>Specificity</th>
								<th>Execution Time (s)</th>
								<th>TP</th>
								<th>TN</th>
								<th>FP</th>
								<th>FN</th>
								<th>Accuracy</th>
								<th>Sensitivity</th>
								<th>Specificity</th>
							</tr>
						</thead>
						<tbody style="text-align: center;">
							<?php if (isset($experiment_results)): ?>
								<?php foreach ($experiment_results as $row): ?>
									<?php $row = (object)$row; ?>
									<tr>
										<td><?= $row->fold_number ?></td>
										<td><?= round($row->execution_time, 2) ?></td>
										<td><?= $row->tp ?></td>
										<td><?= $row->tn ?></td>
										<td><?= $row->fp ?></td>
										<td><?= $row->fn ?></td>
										<td><?= round($row->accuracy, 2) ?></td>
										<td><?= round($row->sensitivity, 2) ?></td>
										<td><?= round($row->specificity, 2) ?></td>
										<td><?= round($row->igr_execution_time, 2) ?></td>
										<td><?= $row->igr_tp ?></td>
										<td><?= $row->igr_tn ?></td>
										<td><?= $row->igr_fp ?></td>
										<td><?= $row->igr_fn ?></td>
										<td><?= round($row->igr_accuracy, 2) ?></td>
										<td><?= round($row->igr_sensitivity, 2) ?></td>
										<td><?= round($row->igr_specificity, 2) ?></td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE CONTENT INNER -->
</div>

<script src="<?= base_url('assets/custom/js/chart.js') ?>"></script>
<script>
// $(document).ready(function() {
// 	const ctx = document.getElementById('result-chart').getContext('2d');
// 	const resultChart = new Chart(ctx, {
// 	    type: 'bar',
// 	    data: {
// 	        labels: ['Accuracy', 'Sensitivity', 'Specificity'],
// 	        datasets: [{
// 	            data: [12, 19, 3],
// 	            backgroundColor: [
// 	                'rgba(255, 99, 132, 0.2)',
// 	                'rgba(54, 162, 235, 0.2)',
// 	                'rgba(255, 206, 86, 0.2)',
// 	            ],
// 	            borderColor: [
// 	                'rgba(255,99,132,1)',
// 	                'rgba(54, 162, 235, 1)',
// 	                'rgba(255, 206, 86, 1)',
// 	            ],
// 	            borderWidth: 1
// 	        }]
// 	    },
// 	    options: {
// 	    	legend: {
// 		        display: false
// 		    },
// 	        scales: {
// 	            yAxes: [{
// 	                ticks: {
// 	                    beginAtZero:true,
// 	                    min: 0,
// 	                    max: 100
// 	                }
// 	            }]
// 	        }
// 	    }
// 	});

// 	const foldCtx = document.getElementById('fold-chart').getContext('2d');
// 	const foldChart = new Chart(foldCtx, {
// 	    type: 'line',
// 	    data: {
// 	        labels: [1, 2, 3],
// 	        datasets: [{
// 	        	label: 'Accuracy',
// 	            data: [12, 19, 3],
// 	            backgroundColor: 'rgba(255, 99, 132, 0.2)',
// 	            borderColor: 'rgba(255,99,132,1)',
// 	            borderWidth: 1,
// 	            fill: false
// 	        }, {
// 	        	label: 'Sensitivity',
// 	            data: [22, 9, 3],
// 	            backgroundColor: 'rgba(54, 162, 235, 0.2)',
// 	            borderColor: 'rgba(54, 162, 235, 1)',
// 	            borderWidth: 1,
// 	            fill: false
// 	        }, {
// 	        	label: 'Specificity',
// 	            data: [15, 39, 10],
// 	            backgroundColor: 'rgba(255, 206, 86, 0.2)',
// 	            borderColor: 'rgba(255, 206, 86, 1)',
// 	            borderWidth: 1,
// 	            fill: false
// 	        }]
// 	    },
// 	    options: {
// 	        scales: {
// 	            yAxes: [{
// 	                ticks: {
// 	                    beginAtZero:true,
// 	                    min: 0,
// 	                    max: 100
// 	                }
// 	            }]
// 	        }
// 	    }
// 	});
// });
</script>