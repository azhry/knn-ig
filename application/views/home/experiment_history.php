<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<div class="row margin-top-10">
		<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Experiment History
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-hover table-bordered" id="sample_1">
						<thead>
							<tr>
								<th>Dataset</th>
								<th>Method</th>
								<th>Number of Folds</th>
								<th>Number of Neighbors</th>
								<th>Thresholds</th>
								<th>Experimented At</th>
								<th>-</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($experiments as $row): ?>
								<tr>
									<td><?= $row->dataset->type ?></td>
									<td><?= $row->type ?></td>
									<td><?= $row->number_of_folds ?></td>
									<td><?= $row->number_of_neighbors ?></td>
									<td><?= $row->thresholds ?></td>
									<td><?= $row->created_at ?></td>
									<td>
										<a class="btn btn-primary btn-xs" href="<?= base_url('app/experiment-details/' . $row->experiment_id) ?>">
											<i class="fa fa-eye"></i> Detail
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	</div>
	<!-- END PAGE CONTENT INNER -->
</div>