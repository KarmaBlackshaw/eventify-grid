<?php 
  require_once dirname(dirname(__DIR__)) . '/lib/init.php';
  $mis = new MIS; 
?>
<form id="activate_student" autocomplete="off">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-dismissible fade show hidden" id="alert_container">
          <span id="alert_message">This is an alert yow!</span>
        </div>
      </div>
      <div class="col-md-6 border-right">
        <div class="form-group">
          <label class="form-label">Name</label>
          <div class="input-group">
            <input type="text" name="first_name" id="student_fname" class="form-control" placeholder="First">
            <input type="text" name="middle_name" id="student_mname" class="form-control" placeholder="Middle">
            <input type="text" name="last_name" id="student_lname" class="form-control" placeholder="Last">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Department</label>
          <select name="department" id="student_department" class="form-control">
            <option value="">Choose Department</option>
            <?php $sql = $mis->getColleges(); ?>
            <?php foreach($sql as $data) : ?>
              <option value="<?= $data->department_id; ?>"><?= $data->department; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Year Level</label>
          <select name="year_level" id="student_year_level" class="form-control">
            <option value="">Year Level</option>
            <option value="1">First</option>
            <option value="2">Second</option>
            <option value="3">Third</option>
            <option value="4">Fourth</option>
          </select>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label class="form-label">
            Student ID
          </label>
          <input type="number" name="student_id" id="student_student_id" class="form-control" placeholder="Student ID">
        </div>
        <div class="form-group">
          <label class="form-label">
            Activation Code
          </label>
          <input type="text" name="activation_code" id="student_activation_code" maxlength="10" class="form-control text-uppercase" placeholder="Activation Code">
        </div>

        <div class="form-group">
          <label class="form-label">
            Username &amp; Password
          </label>
          <div class="input-group">
            <input type="text" name="username" class="form-control" id="student_username" autocomplete="username" placeholder="Username">
            <input type="password" name="password"  class="form-control" id="student_password" placeholder="Password" autocomplete="current-password"> 
          </div>  
          <center><label id="show_password" class="small text-muted hvr-buzz-out no-highlight">Show password</label></center>
        </div>
      </div>
    </div>
    <button class="btn btn-block btn-secondary" disabled type="submit" id="student_btn_activate">Activate</button>
  </div>
</form>

<script src="/assets/jqueries/logins/activate_student.js"></script>