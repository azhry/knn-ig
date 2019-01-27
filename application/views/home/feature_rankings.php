<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-4">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Gabungan
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
								<th>Feature</th>
								<th>Gain</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($gabungan as $row): ?>
								<tr>
									<td><?= $row->feature ?></td>
									<td><?= $row->gain ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Immunotherapy
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
								<th>Feature</th>
								<th>Gain</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($immunotherapy as $row): ?>
								<tr>
									<td><?= $row->feature ?></td>
									<td><?= $row->gain ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Cyrotherapy
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
								<th>Feature</th>
								<th>Gain</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($cyrotherapy as $row): ?>
								<tr>
									<td><?= $row->feature ?></td>
									<td><?= $row->gain ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?= form_open('home/feature-rankings') ?>
	<input type="submit" name="update" value="Rank Features" class="btn blue btn-lg">
	<?= form_close() ?>
	<!-- END PAGE CONTENT INNER -->
</div>