<div class="modal fade" id="modal-edit-inventory-type">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Data Jenis Inventaris</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit-inventory-type">
                <div class="modal-body">
                    <div class="card-body">
                        <input id="edit_id" type="hidden" name="id">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input id="edit_name" type="text" name="name" class="form-control" placeholder="Masukkan Nama...">
                        </div>
                        <div class="form-group">
                            <label for="desc">Deskripsi</label>
                            <textarea id="edit_desc" name="desc" class="form-control" rows="3" placeholder="Masukkan Deskripsi..."></textarea>
                        </div>
                        <div class="form-group mb-0">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input id="edit_is_active" name="is_active" type="checkbox" class="custom-control-input">
                                <label class="custom-control-label" for="edit_is_active">Aktifkan ?</label>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>