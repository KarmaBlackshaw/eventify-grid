<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>

	<div class="page">
	  <div class="page-single">
	    <div class="container">
	      <div class="row">
	        <div class="col  mx-auto" >
	          <form class="card card-lg" id="form_login" action="<?= base_controllers('LoginsController'); ?>" method="POST" autocomplete="off">
	            <div class="card-status bg-blue"></div>
	            <div class="card-header text-center no-highlight">
	              <legend class="hvr-grow display-4 no-highlight" style="-webkit-tap-highlight-color:transparent!important;"><span id="event_title">E</span>MMSA<span id="back_to_login">A</span></legend>
	            </div>
	            <div class="card-body p-6">
	              <div class="card-title font-weight-bold">Student ID</div>
	                <input type="text" class="form-control" id="login_username" placeholder="Enter student ID">
	              <button type="submit" class="btn btn-primary btn-block mt-5" id="btn_login" disabled>Submit</button>
	            </div>
	            <div class="card-footer text-center">
	              <span class="small text-muted">Capstone 2018 - 2019 © Tiktik Gang</span>
	            </div>
	          </form>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>

<?php
	views('login/modal_activate');
	layouts('footer'); 
?>

<script src="<?= assets('jqueries/logins/attendance.js'); ?>"></script>