<div class="modal fade" id="modal_add_user">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add_user">
                <div class="modal-body pt-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="text-sm" for="fullname">Nama Lengkap (<span class="text-danger">*</span>)</label>
                            <input type="text" name="fullname" class="form-control form-control-sm rounded-0" id="fullname" placeholder="Nama Lengkap">
                        </div>
                        <div class="form-group">
                            <label class="text-sm" for="username">Username (<span class="text-danger">*</span>)</label>
                            <input type="text" name="username" class="form-control form-control-sm" id="username" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <label class="text-sm" for="email">Email (<span class="text-danger">*</span>)</label>
                            <input type="email" name="email" class="form-control form-control-sm" id="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label class="text-sm" for="password">Password (<span class="text-danger">*</span>)</label>
                            <input type="password" name="password" class="form-control form-control-sm" id="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label class="text-sm" for="repassword">Konfirmasi Password (<span class="text-danger">*</span>)</label>
                            <input type="password" name="repassword" class="form-control form-control-sm" id="repassword" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label class="text-sm" for="level">Level (<span class="text-danger">*</span>)</label>
                            <select class="form-control form-control-sm" name="level" id="level">
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