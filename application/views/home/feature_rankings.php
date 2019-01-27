<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<?= $this->session->flashdata('msg') ?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">
						Information Gain Rankings
					</div>
				</div>
				<div class="portlet-body">
					<?= form_open('home/feature-rankings') ?>
					<input type="submit" name="update" value="Rank Features" class="btn blue btn-lg">
					<?= form_close() ?>
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE CONTENT INNER -->
</div>