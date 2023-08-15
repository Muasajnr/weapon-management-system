<div class="modal fade" id="modal_edit_password_user">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Passowrd</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_edit_password_user">
                <div class="modal-body pt-0">
                    <div class="card-body">
                        <input type="hidden" name="edit_password_id" id="edit_password_id">
                        <!-- <div class="form-group">
                            <label for="edit_password_lama">Password Lama</label>
                            <input type="password" name="edit_password_lama" class="form-control" id="edit_password_lama" placeholder="Password Lama...">
                        </div> -->
                        <div class="form-group">
                            <label for="edit_password_baru">Password Baru</label>
                            <input type="password" name="edit_password_baru" class="form-control" id="edit_password_baru" placeholder="Password Baru...">
                        </div>
                        <div class="form-group">
                            <label for="edit_repassword_baru">Konfirm Password Baru</label>
                            <input type="password" name="edit_repassword_baru" class="form-control" id="edit_repassword_baru" placeholder="Konfirmasi Password Baru...">
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