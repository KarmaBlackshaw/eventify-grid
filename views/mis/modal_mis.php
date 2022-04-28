<?php $mis = new MIS; ?>
<div class="modal fade" id="modal_students_student_view_student">
  <div class="modal-dialog">
    <div class="modal-content">
      <img src="<?= assets('images/galaxy.png'); ?>" id="modal_students_student_cover" class="cover" height="130" alt="">
      <form action="" id="update_student">
        <div class="card-body">
          <div class="text-center mb-3">
            <img class="card-profile-img border-light hvr-grow-rotate" id="modal_students_student_image" src="<?= assets('images/male.png'); ?>">
            <span class="d-block mb-0 h4" id="modal_students_student_name"></span>
            <small class="text-muted font-italic">
              <span id="modal_students_student_id"></span> &ensp;
              <span class="small font-weight-light" id="modal_students_student_username">(admin)</span>
            </small>
          </div>
          <div class="form-row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>College</label>
                <select id="modal_students_student_college" name="college" class="form-control">
                  <?php $colleges = $mis->getColleges(); ?>
                  <?php foreach($colleges as $college) : ?>
                    <option value="<?= $college->department_id; ?>"><?= acronym($college->department); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Year Level</label>
                <select id="modal_students_student_year_level" name="year_level" class="form-control">
                  <option value="1">First Year</option>
                  <option value="2">Second Year</option>
                  <option value="3">Third Year</option>
                  <option value="4">Fourth Year</option>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>User No.</label>
                <input type="text" class="form-control" id="modal_students_student_user_no" readonly>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Emergency No.</label>
                <input type="text" class="form-control" id="modal_students_student_emergency_no" readonly>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group">
                <label>Activation Code</label>
                <input type="text" class="form-control text-uppercase" id="modal_students_student_activation_code" readonly>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="update_student" name="update_student">
          <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
          <button class="btn btn-primary" type="submit">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_add_department">
  <div class="modal-dialog">
    <form action="" id="form_add_department">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Department</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Department</label>
                <input type="text" class="form-control" name="add_department">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modal_edit_department">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Department</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="col-sm-12">
            <div class="form-group">
              <label>Department</label>
              <input type="text" class="form-control" id="edit_department_department">
              <input type="hidden" id="edit_department_department_id">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn_edit_department">Save Changes</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_remove_department">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>Are you sure to remove <span id="remove_department"></span>?</h4>
        <input type="hidden" id="remove_department_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="btn_remove_department">Sure!</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_manage_employees_view">
  <div class="modal-dialog">
    <div class="modal-content">
      <img src="<?= assets('images/galaxy.png'); ?>" class="cover" height="130" alt="">
      <div class="card-body">
        <div class="text-center mb-3">
          <img class="card-profile-img border-light" id="modal_manage_employees_image" src="<?= assets('images/male.png'); ?>">
          <span class="d-block mb-0 h4" id="modal_manage_employees_name"></span>
          <small class="text-muted font-italic">
            <span id="modal_manage_employee_id"></span> &ensp; (<span id="modal_manage_employee_position_text"></span>)
          </small>
        </div>
        <div class="form-row">
          <div class="col-sm-12">
            <div class="form-group">
              <label>Office</label>
              <select id="modal_manage_employee_office" class="form-control">
                <option value="">Choose office</option>
              </select>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              <label>Position</label>
              <input type="hidden" id="modal_manage_employee_position_hidden">
              <select id="modal_manage_employee_position" class="form-control">
                <option value="">Available positions</option>
              </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>User No.</label>
              <input type="text" class="form-control" id="modal_manage_employee_no" readonly>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Emergency No.</label>
              <input type="text" class="form-control" id="modal_manage_employee_emergency_no" readonly>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              <label>Activation Code</label>
              <input type="text" class="form-control text-uppercase" id="modal_manage_employee_activation_code" readonly>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button class="btn btn-primary" id="btn_modal_manage_employee">Save Changes</button>
        <input type="hidden" class="form-control text-uppercase" id="modal_manage_employee_hidden">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_manage_employee_disabled">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>Are you sure to disable the account of <span id="disable_employee"></span>?</h4>
        <input type="hidden" id="disable_employee_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="btn_disable_employee">Sure!</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_employees_position_add">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Position</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="col-sm-12">
            <div class="form-group">
              <label>Position*</label>
              <input type="text" class="form-control" id="modal_employees_position_add_position" placeholder="Enter position">
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              <label>Office*</label>
              <select id="modal_employees_position_add_office" class="form-control">
                <option value="">Choose position</option>
              </select>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              <label>User Level*</label>
              <select id="modal_employees_position_add_user_level" class="form-control">
                <option value="">Choose position</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn_modal_employees_position_add">Add Position</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_employees_position_edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Position</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="col-sm-12">
            <div class="form-group">
              <label>Position*</label>
              <input type="text" class="form-control" id="modal_employees_position_edit_position" placeholder="Enter position">
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              <label>Office*</label>
              <select id="modal_employees_position_edit_office" class="form-control">
                <option value="">Choose position</option>
              </select>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              <label>User Level*</label>
              <select id="modal_employees_position_edit_user_level" class="form-control">
                <option value="">Choose position</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="hidden"id="modal_employees_position_edit_position_id" placeholder="Enter position">
        <button type="button" class="btn btn-primary" id="btn_modal_employees_position_edit">Add Position</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_manage_employee_position_remove">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>Are you sure to remove <span id="modal_manage_employee_position_remove_text"></span>?</h4>
        <input type="hidden" id="modal_manage_employee_position_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="btn_modal_manage_employee_position_remove">Sure!</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_employees_office_edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Office</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="col-sm-12">
            <div class="form-group">
              <label>Office*</label>
              <input type="text" class="form-control" id="modal_employees_edit_office_name" placeholder="Enter new office name">
              <input type="hidden"id="modal_employees_office_edit_id">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn_modal_employees_office_edit">Save Changes!</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_employees_office_remove">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>Are you sure to remove <span id="modal_employees_office_name_remove"></span>?</h4>
        <input type="hidden" id="modal_employees_office_id_remove">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="btn_modal_employees_office_remove">Sure!</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_employees_office_add">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Office</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="col-sm-12">
            <div class="form-group">
              <label>Office*</label>
              <input type="text" class="form-control" id="modal_employees_office_add_name" placeholder="Enter office name">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn_modal_employees_office_add">Add</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_signature">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Choose Signature</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="card-body o-auto" style="height: 15rem">
        <ul class="list-unstyled list-separated" id="signature_ul">
            <!-- <li class="list-separated-item">
              <div class="row align-items-center">
                <div class="col-auto"> <span class="avatar avatar-md avatar-azure d-block"><i class="fe fe-file-text text-primary"></i></span></div>
                <div class="col">
                  <div>
                    <a href="javascript:void(0)" class="text-inherit">Amanda Hunt</a>
                  </div>
                  <small class="d-block item-except text-sm text-muted h-1x">amanda_hunt@example.com</small>
                </div>
                <div class="col-auto"><button class="btn btn-primary btn-sm signate_select_btn" data-signature_id="asdf">Select</button></div>
              </div>
            </li> -->
          </ul>
        </div>
        <div class="card-footer">

          <input type="search" class="form-control" placeholder="Search file..." id="signature_search">
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal_employees_bldg_coordinator_add">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Register Building Coordinator</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger w-100 hidden" id="modal_bldg_coordinator_add_alert"><b>Error!</b> Employee ID does not exist!</div>
          <div class="form-group">
            <label>Employee ID</label>
            <input type="text" class="form-control" id="bldg_coordinator_employee_id">
          </div>
          <div class="form-group">
            <label>Choose Venue</label>
            <input type="search" class="form-control mb-1" placeholder="Search..." id="bldg_coordinator_bldg_search">
            <div class="card-body o-auto form-control" style="height: 15rem">
              <ul class="list-unstyled list-separated" id="bldg_coordinator_venue_ul">
                <!-- <li class="list-separated-item">
                  <div class="row align-items-center">
                    <div class="col-auto"> <span class="avatar avatar-md avatar-azure d-block"><i class="fe fe-file-text text-primary"></i></span></div>
                    <div class="col">
                      <div>
                        <a href="javascript:void(0)" class="text-inherit">Amanda Hunt</a>
                      </div>
                      <small class="d-block item-except text-sm text-muted h-1x">amanda_hunt@example.com</small>
                    </div>
                    <div class="col-auto"><button class="btn btn-primary btn-sm bldg_coordinator_venue_select">Select</button></div>
                  </div>
                </li> -->
              </ul>
            </div>
          </div>
          <div class="form-group">
            <label>Venue</label>
            <input type="text" class="form-control" id="bldg_coordinator_venue_selected_preview" readonly>
          </div>
        </div>
        <input type="hidden" id="hidden_venue_id">
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btn_register_bldg_coordinator">Register</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal_employees_bldg_coordinator_edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Building Coordinator</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group text-center">
            <p class="h2" id="modal_employees_bldg_coordinator_edit_name"></p>
            <input type="hidden" id="hidden_edit_bldg_coordinator_id">
          </div>
          <div class="form-group">
            <label>Choose New Venue</label>
            <input type="search" class="form-control mb-1" placeholder="Search..." id="bldg_coordinator_bldg_edit_search">
            <div class="card-body o-auto form-control" style="height: 15rem">
              <ul class="list-unstyled list-separated" id="bldg_coordinator_edit_venue_ul_edit">
              </ul>
            </div>
          </div>
          <div class="form-group">
            <label>Venue</label>
            <input type="text" class="form-control" id="bldg_coordinator_edit_venue_selected_preview" readonly>
            <input type="hidden" id="hidden_bldg_coordinator_edit_venue_id">
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="hidden_bldg_coordinator_edit_employees_id">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btn_edit_bldg_coordinator">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal_employees_bldg_coordinator_remove">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure to remove <span id="bldg_coordinator_remove_employee_name" class="h4"></span> as the Building Coordinator of <span id="bldg_coordinator_remove_venue" class="h4"></span> ?</p>
          <input type="hidden" id="hidden_bldg_coordinator_remove_bldg_coordinator_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-primary" id="btn_remove_bldg_coordinator">Sure!</button>
        </div>
      </div>
    </div>
  </div>
