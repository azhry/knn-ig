<div class="page-content">
	<?= $this->session->flashdata('msg') ?>
	<!-- BEGIN PAGE CONTENT INNER -->
	<div class="row margin-top-10">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">Get Result</div>
				</div>
				<div class="portlet-body">
					<?= form_open('app/analysis') ?>
					<div class="form-group">
						<label for="method">Method</label>
						<select class="form-control" required name="method">
							<option value="">Choose Method</option>
							<option value="Classify with KNN">Classify with KNN</option>
							<option value="Classify with IGR - KNN">Classify with IGR - KNN</option>
						</select>
					</div>
					<div class="form-group">
						<label for="threshold">Threshold</label>
						<input class="form-control" type="number" step="any" required name="threshold">
					</div>
					<div class="form-group">
						<label for="k">Number of Fold</label>
						<input class="form-control" type="number" value="10" min="1" required name="k">
					</div>
					<div class="form-group">
						<label for="number_of_neighbors">Number of Neighbors</label>
						<input class="form-control" type="number" min="1" value="1" step="2" required name="number_of_neighbors">
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
						<input type="submit" name="submit" value="Get Results" class="btn blue">
					</div>
					<?= form_close() ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
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
							<?php if (isset($knn_results) or isset($igr_knn_results)): ?>
								<?php if (isset($knn_results, $igr_knn_results)): ?>
									<?php foreach ($knn_results as $i => $row): ?>
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
											<td><?= round($igr_knn_results[$i]['execution_time'], 2) ?></td>
											<td><?= $igr_knn_results[$i]['tp'] ?></td>
											<td><?= $igr_knn_results[$i]['tn'] ?></td>
											<td><?= $igr_knn_results[$i]['fp'] ?></td>
											<td><?= $igr_knn_results[$i]['fn'] ?></td>
											<td><?= round($igr_knn_results[$i]['accuracy'], 2) ?></td>
											<td><?= round($igr_knn_results[$i]['sensitivity'], 2) ?></td>
											<td><?= round($igr_knn_results[$i]['specificity'], 2) ?></td>
										</tr>
									<?php endforeach; ?>
								<?php elseif (isset($knn_results)): ?>
									<?php foreach ($knn_results as $i => $row): ?>
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
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
										</tr>
									<?php endforeach; ?>
								<?php elseif (isset($igr_knn_results)): ?>
									<?php foreach ($igr_knn_results as $i => $row): ?>
										<?php $row = (object)$row; ?>
										<tr>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td><?= $row->fold_number ?></td>
											<td><?= round($row->execution_time, 2) ?></td>
											<td><?= $row->tp ?></td>
											<td><?= $row->tn ?></td>
											<td><?= $row->fp ?></td>
											<td><?= $row->fn ?></td>
											<td><?= round($row->accuracy, 2) ?></td>
											<td><?= round($row->sensitivity, 2) ?></td>
											<td><?= round($row->specificity, 2) ?></td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
							<?php endif; ?>
						</tbody>
						<?php if (isset($knn_results) or isset($igr_knn_results)): ?>
						<tfoot>
							<tr>
								<th>Average</th>
								<th colspan="8">
									<?php if (isset($knn_results)): ?>
										Accuracy: <?= round(array_sum(array_column($knn_results, 'accuracy')) / count($knn_results), 2) ?><br>
										Sensitivity: <?= round(array_sum(array_column($knn_results, 'sensitivity')) / count($knn_results), 2) ?><br>
										Specificity: <?= round(array_sum(array_column($knn_results, 'specificity')) / count($knn_results), 2) ?><br>
										Execution Time: <?= round(array_sum(array_column($knn_results, 'execution_time')) / count($knn_results), 2) ?>s
									<?php endif; ?>
								</th>
								<th colspan="8">
									<?php if (isset($igr_knn_results)): ?>
										Accuracy: <?= round(array_sum(array_column($igr_knn_results, 'accuracy')) / count($igr_knn_results), 2) ?><br>
										Sensitivity: <?= round(array_sum(array_column($igr_knn_results, 'sensitivity')) / count($igr_knn_results), 2) ?><br>
										Specificity: <?= round(array_sum(array_column($igr_knn_results, 'specificity')) / count($igr_knn_results), 2) ?><br>
										Execution Time: <?= round(array_sum(array_column($igr_knn_results, 'execution_time')) / count($igr_knn_results), 2) ?>s
									<?php endif; ?>
								</th>
							</tr>
							<tr>
								<th>Features</th>
								<th colspan="8">
									<?php if (isset($knn_features)): ?>
										<ul>
											<?php foreach ($knn_features as $feature): ?>
												<li><?= $feature ?></li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
								</th>
								<th colspan="8">
									<?php if (isset($igr_knn_features)): ?>
										<ul>
											<?php foreach ($igr_knn_features as $feature): ?>
												<li><?= $feature ?></li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
								</th>
							</tr>
						</tfoot>
						<?php endif; ?>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE CONTENT INNER -->
</div>