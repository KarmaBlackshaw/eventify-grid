
<form id="activate_administration" autocomplete="off">
  <div class="card-body">
    <div class="row">
    <div class="col-md-12">
    	<div class="alert alert-dismissible fade show hidden" id="alert_container">
    	  <span id="alert_message">This is an alert yow!</span>
    	</div>
    </div>
	<div class="col-md-12">
	</div>
      <div class="col-md-6 border-right">
        <div class="form-group">
          <label class="form-label">Name</label>
          <div class="input-group">
            <input type="text" id="administration_fname" class="form-control" placeholder="First">
            <input type="text" id="administration_mname" class="form-control" placeholder="Middle">
            <input type="text" id="administration_lname" class="form-control" placeholder="Last">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Office</label>
          <select class="form-control" id="administration_office">
            <option value="">Choose Office</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Position</label>
          <select name="" class="form-control" id="administration_position">
            <option value="">Select Position</option>
          </select>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label class="form-label">
            Employee ID
          </label>
            <input type="number" id="administration_employee_id" class="form-control" placeholder="Employee ID">
        </div>
        <div class="form-group">
          <label class="form-label">
            Activation Code
          </label>
            <input type="text" maxlength="10" id="administration_activation_code" class="form-control text-uppercase" placeholder="Activation Code">
        </div>

        <div class="form-group">
          <label class="form-label">
            Username &amp; Password
          </label>
          <div class="input-group">
            <input type="text" id="administration_username" class="form-control" placeholder="Username" autocomplete="username">
            <input type="password" id="administration_password" class="form-control" placeholder="Password" autocomplete="current-password">
          </div>
          <center><label id="show_password" class="small text-muted hvr-buzz-out no-highlight">Show password</label></center>
        </div>
      </div>
    </div>
    <button class="btn btn-block btn-secondary" disabled type="button" id="administration_btn_activate">Activate</button>
  </div>
</form>

<script src="/assets/jqueries/logins/activate_administration.js"></script>
<!-- <script src="/Framework/assets/jqueries/logins/activate_administration.js"></script> -->