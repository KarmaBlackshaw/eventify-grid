<?php 
	require_once __DIR__ . '/layout/header.php';

	$errors = [
		1 => '<b>Error!</b> All fields are required!',
		2 => '<b>Error!</b> Something went wrong! Please contact the administrator!',
		3 => '<b>Error!</b> Username is not recognized!',
		4 => '<b>Error!</b> Password is incorrect!',
		5 => '<b>Error!</b> User unidentified!'
	];
?>

<div class=" py-4 bg-blue-darker">
  <div class="container">
    <div class="row">
      <a class="header-brand text-white mb-2" href="javascript:">
        
        <span class="container">
        	<img src="<?= assets('images/calendar.png'); ?>" class="header-brand-img" alt="">
        	Eventify Grid
        </span>
      </a>
    </div>
  </div>
</div>

	<div class="page">
	  <div class="page-single">
	    <div class="container">
	      <div class="row">
	        <div class="col col-login mx-auto" >
			<?php if(isset($_GET['e'])) : ?>
            	<div class="alert alert-danger" role="alert">
            	  <?= $errors[$_GET['e']]; ?>
            	</div>
            <?php endif; ?>
	          <form class="card card-lg" id="form_login" action="<?= base_controllers('LoginsController'); ?>" method="POST" autocomplete="off">
	            <div class="card-status bg-blue-darker"></div>
	            <div class="card-header text-center">
	              <legend class="hvr-grow display-4 no-highlight" style="-webkit-tap-highlight-color:transparent!important;" id="index_system_title">
	              	Account Login
	              </legend>
	            </div>
	            <div class="card-body p-6">
	              <label class="form-label">Username</label>
	              <div class="input-icon form-group">
	                <span class="input-icon-addon">
	                  <i class="fe fe-user"></i>
	                </span>
	                <input type="text" class="form-control" id="login_username" name="login_username" placeholder="Enter username" autocomplete="username">
	              </div>

	              <label class="form-label">Password</label>
	              <div class="input-icon form-group">
	                <span class="input-icon-addon">
	                  <i class="fe fe-lock"></i>
	                </span>
	                <input type="password" class="form-control" id="login_password" name="login_password" placeholder="Enter password" autocomplete="current-password">
	              </div>
	              <button type="submit" class="btn bg-blue-darker text-white btn-block" id="btn_login" name="btn_login" disabled>
	              	<div class="spinner-grow spinner-grow-sm" id="spinner" role="status">
	              	  <span class="sr-only">Loading...</span>
	              	</div>
	              </button>
	            </div>
	          </form>

	          <div class="text-center text-muted">
	            Account not activated yet? <a href="javascript:void(0)" data-target="#modal_activate" data-toggle="modal">Activate!</a>
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
<?php
	views('login/modal_activate');
	layouts('footer'); 
	// https://github.com/ziadoz/awesome-php#frameworks -->
?>
<script src="<?= assets('jqueries/logins/login.js'); ?>"></script>