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


<div class="modal fade" id="modal_disapprove_event">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>Are you sure to disapprove <span class="font-weight-bold" id="event_name"></span></h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="modal_btn_disapprove_event">Yes!</button>
      </div>
    </div>
  </div>
</div>