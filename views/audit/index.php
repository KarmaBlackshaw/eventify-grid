<?php 
	require_once dirname(__DIR__) . '/layout/header.php';
	models('layouts/navbar_default');
	layouts('navbar');
	$audit = new Audit;

	$sql = $audit->getUserAudits();
?>

<div class="my-3 my-md-5">
	<div class="container">
		<div class="row">
		  <div class="col-md-2">
		    <h3 class="page-title mb-5">Audit Trails</h3>
		    <div>
		      <div class="list-group list-group-transparent mb-0 nav-pills">
		        <a href="javascript:void(0)" class="list-group-item list-group-item-action d-flex align-items-center active" data-target="events_approval">
		          <span class="icon mr-3"><i class="fe fe-map"></i></span> Logs
		        </a>
		      </div>
		    </div>
		  </div>

		  <div class="col-md-10" id="events_container">

		  	<div class="row row-cards row-deck" id="events_manage_container">
		  	  <div class="col-lg-12">
		  	    <div class="card">
		  	      <div class="card-header">
		  	        <div class="col"><h3 class="card-title">Logs Table</h3></div>
		  	      </div>
		  	      <a href="#">
		  	        <img src="<?= base_assets('images/placeholders/975x180.png'); ?>" lass="card-img top">
		  	      </a>
		  	      <div class="table-responsive">
		  	      	<input type="search" id="search_audit" class="form-control" placeholder="Search...">
		  	        <table class="table card-table table-striped table-vcenter" id="table_audits">
		  	          <thead>
		  	            <tr>
		  	              <th>Action</th>
		  	              <th>Date</th>
		  	            </tr>
		  	          </thead>
		  	          <tbody>
		  	          	<?php foreach($sql as $data) : ?>
	  	          		<tr>
	  	          			<td class="font-weight-bold"> <?= ucfirst("You " . lcfirst($data->action)); ?></td>
	  	          			<td><?= $data->created_at; ?></td>
	  	          		</tr>
		  	          	<?php endforeach; ?>
		  	          </tbody>
		  	        </table>
		  	      </div>
		  	    </div>
		  	  </div>
		  	</div>
		  	
		  </div>
		</div>
	</div>
</div>

<?php layouts('footer'); ?>
<script src="<?= assets('jqueries/audits/audit.js?'); ?>"></script>