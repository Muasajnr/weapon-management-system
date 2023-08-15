<div class="modal fade" id="modal_edit_user">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_edit_user">
                <div class="modal-body pt-0">
                    <div class="card-body">
                        <input type="hidden" name="edit_id" id="edit_id">
                        <div class="form-group">
                            <label class="text-sm" for="edit_fullname">Nama Lengkap (<span class="text-danger">*</span>)</label>
                            <input type="text" name="edit_fullname" class="form-control form-control-sm rounded-0" id="edit_fullname" placeholder="Nama Lengkap">
                        </div>
                        <div class="form-group">
                            <label class="text-sm" for="edit_username">Username (<span class="text-danger">*</span>)</label>
                            <input type="text" name="edit_username" class="form-control form-control-sm" id="edit_username" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <label class="text-sm" for="edit_email">Email (<span class="text-danger">*</span>)</label>
                            <input type="email" name="edit_email" class="form-control form-control-sm" id="edit_email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label class="text-sm" for="edit_level">Level (<span class="text-danger">*</span>)</label>
                            <select class="form-control form-control-sm" name="edit_level" id="edit_level">
                                <option value="admin">Admin</option>
                                <option value="user">Reguler</option>
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>