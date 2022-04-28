<?php  

$bldg = new Bldg();
$ssc = new SSC();

?>

<div class="modal fade" id="modal_add_school_calendar_event">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add School Calendar Event</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Event</label>
          <input type="text" class="form-control" name="modal_school_calendar_event_name" id="modal_school_calendar_event_name">
        </div>
        <div class="form-group">
          <label>Date of Use</label>
          <input type="date" class="form-control" name="modal_school_calendar_event_date" id="modal_school_calendar_event_date">
        </div>
        <input type="hidden" name="modal_school_calendar_event_hidden">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="modal_add_school_calendar_event_btn">Add</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_event_approve">
  <div class="modal-dialog modal-lg">
    <form action="" id="modal_school_calendar_event_form">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- <h4 class="font-weight-light">Are you sure to approve Birthday<span class="font-weight-bold" id="event_approve_name"></span></h4> -->

          <table class="table table-bordered table-md mb-1">
            <tbody>
              <tr>
                <td width="20%" class="small text-right bg-blue-lightest">Event</td>
                <td id="event_name">Christmas Party</td>
              </tr>
              <tr>
                <td width="20%" class="small text-right bg-blue-lightest">Recipients</td>
                <td>
                  <ul class="mb-0 pl-4" id="event_ul_recipient">
                  </ul>
                </td>
              </tr>
              <tr>
                <td width="20%" class="small text-right bg-blue-lightest">Venue</td>
                <td id="event_venue">ORC Quadrangle</td>
              </tr>
              <tr>
                <td width="20%" class="small text-right bg-blue-lightest">Facilities</td>
                <td>
                  <ul class="mb-0 pl-4" id="event_ul_facilities">
                  </ul>
                </td>
              </tr>
              <tr>
                <td width="20%" class="small text-right bg-blue-lightest">Requesting Party</td>
                <td id="event_requesting_party">Karma Blackshaw</td>
              </tr>
              <tr>
                <td width="20%" class="small text-right bg-blue-lightest">Date of Use</td>
                <td id="event_date_of_use">January 20, 2018</td>
              </tr>
              <tr>
                <td width="20%" class="small text-right bg-blue-lightest">Inclusive Time</td>
                <td id="event_time">10:20AM - 1:30PM</td>
              </tr>
              <tr>
                <td width="20%" class="small text-right bg-blue-lightest">Composer</td>
                <td id="event_composer">Ernie Jeash</td>
              </tr>
            </tbody>
          </table>
          <div align="right">
            <small class="text-muted font-italic">For more information, please download the <a href="javascript:" id="event_pdf_link" download>pdf</a>.</small>  
          </div>
          <input type="hidden" id="event_approve_hidden_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-primary" id="event_approve">Approve!</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_event_status">
  <div class="modal-dialog modal-lg">
    <form action="" id="modal_school_calendar_event_form">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Event Approval Status Report</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered table-md table-striped" id="table_event_status">
            <thead>
              <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th width="10">Status</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modal_event_disapprove">
  <div class="modal-dialog">
    <form action="" id="modal_school_calendar_event_form">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h4 class="font-weight-light">Are you sure to disapprove <span id="event_name" class="font-weight-bold"></span> ?</h4>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-primary" id="event_disapprove">Disapprove!</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modal_view_reports">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">View Student Reports</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row pl-2">
          <div class="col-md">
            <i class="fas fa-user fa-lg mr-2"></i> <span class="h5 reports_name">Ernie Jeash C. Villahermosa</span>
          </div>
          <div class="col-md">
            <i class="fas fa-graduation-cap fa-lg mr-2"></i> <span class="h5 reports_course_section">BSIT - 4th Year</span>
          </div>
        </div>
        <hr class="m-3">

        <table class="table table-hover table-striped">
          <thead>
            <tr>
              <th>Event</th>
              <th>Date</th>
              <th>Time</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php for($i = 0; $i < 5; $i++) : ?>
            <tr>
              <td>Christmas Party</td>
              <td>Dec 25, 2019</td>
              <td>7:30AM - 5:00PM</td>
              <td><span class="badge hvr-grow bg-red-light p-1 no-highlight d-block m-1">Absent</span></td>
              <td class="text-center"><button class="btn btn-outline-primary btn-sm">Clear</button></td>
            </tr>
            <?php endfor; ?>

            <tr>
              <td>JS Promenade</td>
              <td>Dec 25, 2019</td>
              <td>7:30AM - 5:00PM</td>
              <td><span class="badge hvr-grow bg-green-light p-1 no-highlight d-block m-1">Present</span></td>
              <td class="text-center"></td>
            </tr>
            <tr>
              <td>Senior's Ball</td>
              <td>Dec 25, 2019</td>
              <td>7:30AM - 5:00PM</td>
              <td><span class="badge hvr-grow bg-orange p-1 no-highlight d-block m-1">Absent</span></td>
              <td class="text-center"><button class="btn btn-outline-success btn-sm">Cleared</button></td>
            </tr>
          </tbody>
        </table>

        <hr class="m-3">

        <div class="col">
          <span class="float-right">Total Absents: <b>5</b></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Ok!</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_print_event">
  <div class="modal-dialog">
    <form action="<?= base_views('ssc/reports/pdf_reports_events'); ?>" method="POST" target="_blank">
      <div class="modal-content">
        <!-- <form action="<?= base_views('ssc/reports/pdf_reports_events'); ?>" method="POST"> -->
          <div class="modal-header">
            <h5 class="modal-title">Print Options</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Year & Month</label>
              <div class="input-group">
                <select name="year" id="" class="form-control">
                  <option value="">All Year</option>
                  <?php foreach($bldg->getYears() as $years) : ?>
                    <option value="<?= $years->years ?>"><?= $years->years ?></option>
                  <?php endforeach; ?>
                </select>
                <select name="month" id="" class="form-control">
                  <option value="">All Month</option>
                  <?php foreach(get_months() as $key => $val) : ?>
                    <option value="<?= $key + 1; ?>"><?= $val; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label>Status</label>
              <select name="status_id" id="" class="form-control">
                <option value="">All Status</option>
                <?php foreach($ssc->getStatuses() as $data) : ?>
                  <option value="<?= $data->status_id; ?>"><?= $data->status; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Order by</label>
              <div class="input-group">
                <select name="order_by" id="" class="form-control">
                  <option value="e.event_id">Event Date</option>
                  <option value="likes">Likes</option>
                  <option value="dislikes">Dislikes</option>
                </select>

                <select name="order" id="" class="form-control">
                  <option value="asc">Ascending</option>
                  <option value="desc">Descending</option>
                </select>
              </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <input type="hidden" name="print_event_reports">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Print!</button>
          </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modal_import_attendance">
  <div class="modal-dialog">
    <form id="form_import_attendance">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Import Attendance</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>File: </label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="import_file">
                <label class="custom-file-label">Choose file</label>
              </div>
              <small class="text-muted font-weight-light font-italic">File must be a txt type</small>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="import_file_hidden" id="import_file_hidden">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Import</button>
          </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="modal_view_imports">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">View Imports</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body table-responsive">
          <table class="table table-hover table-bordered table-striped" id="table_view_imports">
            <thead class="thead-light">
              <th>Event Date</th>
              <th>Status</th>
              <th>Import Date</th>
            </thead>
            <tbody></tbody>
          </table>
        </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modal_view_event">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">View Event</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="col-md-6 col-sm-12">
            <div class="form-group">
              <label class="small">Activity/Event</label>
              <input type="text" class="form-control" id="event_name" disabled>
            </div>
          </div>
          <div class="col-md-6 col-sm-12">
            <div class="form-group">
              <label class="small">Requesting Party</label>
              <input type="text" class="form-control" id="requesting_party" disabled>
            </div>
          </div>
          <div class="col-md-4 col-sm-12">
            <div class="form-group">
              <label class="small">Date of Use</label>
              <input type="text" class="form-control" id="date_of_use" disabled>
            </div>
          </div>
          <div class="col-md-4 col-sm-12">
            <div class="form-group">
              <label class="small">Inclusive Time</label>
              <input type="text" class="form-control" id="inclusive_time" disabled>
            </div>
          </div>
          <div class="col-md-4 col-sm-12">
            <div class="form-group">
              <label class="small">Venue Requested</label>
              <input type="text" class="form-control" id="venue" disabled>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              <label class="small">Recipients</label>
              <ul class="list-group" id="recipients_list_group">
                <li class="list-group-item p-2">Cras justo odio</li>
              </ul>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              <label class="small">Audio-Visual Facilities</label>
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter" id="items_table">
                  <thead class="thead-light">
                    <tr>
                      <th>Facility</th>
                      <th>Type</th>
                      <th>Quantity</th>
                    </tr>
                  </thead>
                  <tbody>
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

<div class="modal fade" id="modal_clear_student">
  <div class="modal-dialog">
    <form action="" id="modal_school_calendar_event_form">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h4 class="font-weight-light">Are you sure to clear this student from his repercussions?</h4>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="event_id">
          <input type="hidden" id="student_id">
          <input type="hidden" id="date">
          <input type="hidden" id="students_id">

          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-primary" id="clear_student">Yes!</button>
        </div>
      </div>
    </form>
  </div>
</div>