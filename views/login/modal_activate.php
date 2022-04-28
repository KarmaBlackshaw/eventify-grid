<div class="modal fade" id="modal_activate">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <div class="card-status bg-success"></div>
        <h5 class="modal-title">Activate Account</h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body">
        <select id="activate_user_level" class="form-control">
        	<option value="">Choose user level</option>
          <option value="student">Student</option>
          <option value="administration">Employee</option>
        </select>
        <div id="content"></div>
      </div>
      <div class="modal-footer text-center">
        <span class="small text-muted">Capstone 2018 - 2019 © Tiktik Gang</span>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_select_event">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <div class="card-status bg-success"></div>
        <h5 class="modal-title">Officer Login</h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body">
        <div class="form-group" id="attendance_login_container">
          <?php include 'attendance_officer_login.php'; ?>
        </div>
      </div>
      <div class="modal-footer text-center">
        <span class="small text-muted">Capstone 2018 - 2019 © Tiktik Gang</span>
      </div>
    </div>
  </div>
</div>