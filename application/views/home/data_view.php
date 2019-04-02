<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-8">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Data
					</div>
					<div class="caption pull-right">
						<a href="<?= base_url('app/clear-data') ?>" class="btn red btn-xs"><i class="fa fa-trash"></i> Clear Data</a>
					</div>
				</div>
				<div class="portlet-body">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#tab_gabungan" data-toggle="tab">
							Gabungan </a>
						</li>
						<li>
							<a href="#tab_immunotherapy" data-toggle="tab">
							Immunotherapy </a>
						</li>
						<li>
							<a href="#tab_cyrotherapy" data-toggle="tab">
							Cyrotherapy </a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade active in" id="tab_gabungan">
							<table class="table table-striped table-hover table-bordered">
								<thead>
									<tr>
										<th>No.</th>
										<th>Sex</th>
										<th>Age</th>
										<th>Time</th>
										<th>Number of Warts</th>
										<th>Type</th>
										<th>Area</th>
										<th>Result of Treatment</th>
										<!-- <th>Action</th> -->
									</tr>
								</thead>
								<tbody>
									<?php foreach ($patients as $i => $row): ?>
										<tr>
											<td><?= $i + 1 ?></td>
											<td><?= $row->sex == 1 ? 'Male' : 'Female' ?></td>
											<td><?= $row->age ?></td>
											<td><?= $row->time ?></td>
											<td><?= $row->number_of_warts ?></td>
											<td><?= $row->type ?></td>
											<td><?= $row->area ?></td>
											<td><?= $row->result_of_treatment ?></td>
											<!-- <td>
												<div class="btn-group">
													<button class="btn blue" type="button">
														<i class="fa fa-edit"></i> Edit
													</button>
													<button class="btn red" type="button">
														<i class="fa fa-trash"></i> Delete
													</button>
												</div>
											</td> -->
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
						<div class="tab-pane fade" id="tab_immunotherapy">
							<table class="table table-striped table-hover table-bordered">
								<thead>
									<tr>
										<th>No.</th>
										<th>Sex</th>
										<th>Age</th>
										<th>Time</th>
										<th>Number of Warts</th>
										<th>Type</th>
										<th>Area</th>
										<th>Induration Diameter</th>
										<th>Result of Treatment</th>
										<!-- <th>Action</th> -->
									</tr>
								</thead>
								<tbody>
									<?php foreach ($immunotherapy as $i => $row): ?>
										<tr>
											<td><?= $i + 1 ?></td>
											<td><?= $row->sex == 1 ? 'Male' : 'Female' ?></td>
											<td><?= $row->age ?></td>
											<td><?= $row->time ?></td>
											<td><?= $row->number_of_warts ?></td>
											<td><?= $row->type ?></td>
											<td><?= $row->area ?></td>
											<td><?= $row->induration_diameter ?></td>
											<td><?= $row->result_of_treatment ?></td>
											<!-- <td>
												<div class="btn-group">
													<button class="btn blue" type="button">
														<i class="fa fa-edit"></i> Edit
													</button>
													<button class="btn red" type="button">
														<i class="fa fa-trash"></i> Delete
													</button>
												</div>
											</td> -->
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
						<div class="tab-pane fade" id="tab_cyrotherapy">
							<table class="table table-striped table-hover table-bordered">
								<thead>
									<tr>
										<th>No.</th>
										<th>Sex</th>
										<th>Age</th>
										<th>Time</th>
										<th>Number of Warts</th>
										<th>Type</th>
										<th>Area</th>
										<th>Result of Treatment</th>
										<!-- <th>Action</th> -->
									</tr>
								</thead>
								<tbody>
									<?php foreach ($cyrotherapy as $i => $row): ?>
										<tr>
											<td><?= $i + 1 ?></td>
											<td><?= $row->sex == 1 ? 'Male' : 'Female' ?></td>
											<td><?= $row->age ?></td>
											<td><?= $row->time ?></td>
											<td><?= $row->number_of_warts ?></td>
											<td><?= $row->type ?></td>
											<td><?= $row->area ?></td>
											<td><?= $row->result_of_treatment ?></td>
											<!-- <td>
												<div class="btn-group">
													<button class="btn blue" type="button">
														<i class="fa fa-edit"></i> Edit
													</button>
													<button class="btn red" type="button">
														<i class="fa fa-trash"></i> Delete
													</button>
												</div>
											</td> -->
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">Add Data (Gabungan)</div>
				</div>
				<div class="portlet-body">
					<?= form_open('app/data') ?>
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
						<label for="result_of_treatment">Result of Treatment</label>
						<input type="number" name="result_of_treatment" class="form-control">
					</div>
					<div class="form-group">
						<input type="submit" name="submit_gabungan" value="Submit" class="btn blue">
					</div>
					<?= form_close() ?>
				</div>
			</div>
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">Add Data (Immunotherapy)</div>
				</div>
				<div class="portlet-body">
					<?= form_open('app/data') ?>
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
						<label for="result_of_treatment">Result of Treatment</label>
						<input type="number" name="result_of_treatment" class="form-control">
					</div>
					<div class="form-group">
						<input type="submit" name="submit_immunotherapy" value="Submit" class="btn blue">
					</div>
					<?= form_close() ?>
				</div>
			</div>
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">Add Data (Cyrotherapy)</div>
				</div>
				<div class="portlet-body">
					<?= form_open('app/data') ?>
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
						<label for="result_of_treatment">Result of Treatment</label>
						<input type="number" name="result_of_treatment" class="form-control">
					</div>
					<div class="form-group">
						<input type="submit" name="submit_cyrotherapy" value="Submit" class="btn blue">
					</div>
					<?= form_close() ?>
				</div>
			</div>
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">Import Data (Gabungan)</div>
				</div>
				<div class="portlet-body">
					<?= form_open_multipart('app/data') ?>
					<div class="form-group">
						<label for="upload">Upload File (.xlsx)</label>
						<input type="file" name="file" class="form-control">
					</div>
					<div class="form-group">
						<input type="submit" name="import_gabungan" value="Import" class="btn blue">
					</div>
					<?= form_close() ?>
				</div>
			</div>
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">Import Data (Immunotherapy)</div>
				</div>
				<div class="portlet-body">
					<?= form_open_multipart('app/data') ?>
					<div class="form-group">
						<label for="upload">Upload File (.xlsx)</label>
						<input type="file" name="file" class="form-control">
					</div>
					<div class="form-group">
						<input type="submit" name="import_immunotherapy" value="Import" class="btn blue">
					</div>
					<?= form_close() ?>
				</div>
			</div>
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">Import Data (Cyrotherapy)</div>
				</div>
				<div class="portlet-body">
					<?= form_open_multipart('app/data') ?>
					<div class="form-group">
						<label for="upload">Upload File (.xlsx)</label>
						<input type="file" name="file" class="form-control">
					</div>
					<div class="form-group">
						<input type="submit" name="import_cyrotherapy" value="Import" class="btn blue">
					</div>
					<?= form_close() ?>
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE CONTENT INNER -->
</div>