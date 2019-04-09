<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<div class="row margin-top-10">
		<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Experiment Details
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-hover table-bordered" id="sample_1">
						<thead>
							<tr>
								<th>Fold Number</th>
								<th>TP</th>
								<th>TN</th>
								<th>FP</th>
								<th>FN</th>
								<th>Accuracy</th>
								<th>Sensitivity</th>
								<th>Specificity</th>
								<th>Execution Time</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($experiments->details as $row): ?>
								<tr>
									<td><?= $row->fold_number ?></td>
									<td><?= $row->tp ?></td>
									<td><?= $row->tn ?></td>
									<td><?= $row->fp ?></td>
									<td><?= $row->fn ?></td>
									<td><?= $row->accuracy ?></td>
									<td><?= $row->sensitivity ?></td>
									<td><?= $row->specificity ?></td>
									<td><?= $row->execution_time ?></td>
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