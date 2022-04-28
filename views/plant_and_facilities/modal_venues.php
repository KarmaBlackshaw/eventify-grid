<!-- Table Manage Venues -->
<div class="modal fade" id="modal_edit_table_venues" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="" id="modal_venue_form">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Venue</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <a href="#" class="image_container">
          <img class="card-img-top cover" src="" height="100px" id="modal_venue_image">
        </a>
        <div class="modal-body form-row">
          <div class="alert alert-dismissible fade show hidden w-100" id="modal_venue_message_board_edit">
            <span id="modal_venue_message_edit"></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <input type="hidden" id="modal_venue_id" name="modal_venue_id">
          <div class="col-sm-12">
            <div class="form-group">
              <label class="form-label">Name</label>
              <input type="text" class="form-control" id="modal_venue_name" name="modal_venue_name">
              <i><small class="text-muted">Bldg. Coordinator: <span class="text-dark" id="modal_venue_bldg_coordinator" name="modal_venue_bldg_coordinator">Ernie Jeash</span></small></i>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label class="form-label">Capacity <small class="text-muted"><i>(Person)</i></small></label>
              <input type="text" class="form-control" id="modal_venue_capacity" name="modal_venue_capacity">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label class="form-label">Price</label>
              <input type="number" class="form-control" id="modal_venue_price" name="modal_venue_price">
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              <label class="form-label">Change Image</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="modal_venue_change_image" name="modal_venue_change_image">
                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
              </div>
              <small class="text-muted font-italic">For best experience, use an image of below 1280x720p resolution.</small>
            </div>
          </div>
        </div>
        <input type="hidden" name="edit_venue">
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="modal_venue_edit_btn">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_remove_table_venues">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmations</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>Are you sure to remove <span id="modal_remove_venue"></span>?</h4>
        <input type="hidden" id="modal_venue_remove_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="modal_venue_remove_btn" data-venue-id="">Sure!</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_confirm_restore_venue">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmations</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4><span class="font-weight-light">Are you sure you want to restore</span> <span id="modal_restore_venue"></span>?</h4>
        <input type="hidden" id="modal_venue_remove_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="modal_trash_restore_btn" data-venue-id="">Sure!</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_events_approval_approve">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="col-md-6 col-sm-4">
            <div class="form-group">
              <label class="small">Activity/Event</label>
              <input type="text" class="form-control" value="Christmas Party" disabled>
            </div>
          </div>
          <div class="col-md-6 col-sm-4">
            <div class="form-group">
              <label class="small">Requesting Party</label>
              <input type="text" class="form-control" value="Christmas Party" disabled>
            </div>
          </div>
          <div class="col-md-6 col-sm-4">
            <div class="form-group">
              <label class="small">Date of Use</label>
              <input type="text" class="form-control" value="January 10 - 18, 2018" disabled>
            </div>
          </div>
          <div class="col-md-6 col-sm-4">
            <div class="form-group">
              <label class="small">Inclusive Time</label>
              <input type="text" class="form-control" value="7:00 AM - 9:30 PM" disabled>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              <label class="small">Venue Requested</label>
              <input type="text" class="form-control" value="HRDC GYM" disabled>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              <label class="small">Audio-Visual Facilities</label>
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter mt-1">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Facility</th>
                      <th>Type</th>
                      <th>Quantity</th>
                    </tr>
                  </thead>
                  <tbody id="tbody_events_approval">
                    <tr>
                      <td><small>1</small></td>
                      <td><small>Amplifier</small></td>
                      <td><b>Audio System</b></td>
                      <td>4 pcs.</td>
                    </tr>
                    <tr>
                      <td><small>2</small></td>
                      <td><small>Amplifier</small></td>
                      <td><b>Audio System</b></td>
                      <td>4 pcs.</td>
                    </tr>
                    <tr>
                      <td><small>3</small></td>
                      <td><small>Amplifier</small></td>
                      <td><b>Audio System</b></td>
                      <td>4 pcs.</td>
                    </tr>
                    <tr>
                      <td><small>4</small></td>
                      <td><small>Amplifier</small></td>
                      <td><b>Audio System</b></td>
                      <td>4 pcs.</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="modal_trash_restore_btn" data-venue-id="">Sure!</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_approve_event">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
            <div class="col-md-6 col-sm-4">
              <div class="form-group">
                <label class="small">Activity/Event</label>
                <input type="text" class="form-control" id="event_name" disabled>
              </div>
            </div>
            <div class="col-md-6 col-sm-4">
              <div class="form-group">
                <label class="small">Requesting Party</label>
                <input type="text" class="form-control" id="requesting_party" disabled>
              </div>
            </div>
            <div class="col-md-6 col-sm-4">
              <div class="form-group">
                <label class="small">Date of Use</label>
                <input type="text" class="form-control" id="date_of_use" disabled>
              </div>
            </div>
            <div class="col-md-6 col-sm-4">
              <div class="form-group">
                <label class="small">Inclusive Time</label>
                <input type="text" class="form-control" id="inclusive_time" disabled>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group">
                <label class="small">Venue Requested</label>
                <input type="text" class="form-control" id="venue" disabled>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group">
                <label class="small">Audio-Visual Facilities</label>
                <div class="table-responsive">
                  <table class="table table-bordered table-striped table-vcenter mt-1" id="items_table">
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
      <div class="modal-footer">
        <input type="hidden" id="event_id">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="modal_btn_approve_event">Approve!</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="call_modal_disapprove">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmations</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>Are you sure to disapprove <span id="modal_remove_venue"></span>?</h4>
        <input type="hidden" id="modal_venue_remove_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="modal_venue_remove_btn">Sure!</button>
      </div>
    </div>
  </div>
</div>
