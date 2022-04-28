

<div class="modal fade" id="modal_demote_ssc">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmations</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>Are you sure to remove <span id="demote_ssc_name"></span>?</h4>
        <input type="hidden" id="demote_ssc_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="btn_demote_ssc">Sure!</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_remove_position">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmations</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>Are you sure to remove <span id="remove_position"></span>?</h4>
        <input type="hidden" id="remove_position_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="btn_remove_position">Sure!</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_edit_position">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="form_edit_position" autocomplete="off">
        <div class="modal-header">
          <h5 class="modal-title">Update Position</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label class="small text-muted">Position</label>
          <input type="text" class="form-control" id="edit_position" name="edit_position">
          <input type="hidden" id="edit_position_id" name="edit_position_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button type="submit" class="btn btn-primary">Update!</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_add_position">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="form_add_position" autocomplete="off">
        <div class="modal-header">
          <h5 class="modal-title">Update Position</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label class="small text-muted">Position</label>
          <input type="text" class="form-control" id="add_position" name="add_position">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button type="submit" class="btn btn-primary">Add!</button>
        </div>
      </form>
    </div>
  </div>
</div>