<div class="modal fade" id="modal_add_jenis_sarana">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah <?=$page_title?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add_jenis_sarana">
                <div class="modal-body pt-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan Nama...">
                        </div>
                        <div class="form-group">
                            <label for="desc">Deskripsi</label>
                            <textarea id="desc" name="desc" class="form-control" rows="3" placeholder="Masukkan Deskripsi..."></textarea>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" name="is_active" class="custom-control-input" id="is_active">
                                <label class="custom-control-label" for="is_active">Aktifkan ?</label>
                            </div>
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