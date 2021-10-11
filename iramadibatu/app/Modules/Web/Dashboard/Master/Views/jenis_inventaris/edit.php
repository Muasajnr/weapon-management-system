<div class="modal fade" id="modal-edit-jenis-inventaris">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit <?=$page_title?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <div class="modal-body pb-0">
                <div class="card-body pb-0 pt-0 text-right">
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                        <input type="checkbox" name="is_single_insert" class="custom-control-input" id="is_single_insert" disabled>
                        <label class="custom-control-label" for="is_single_insert">Single-Insert</label>
                    </div>
                </div>
            </div> -->
            <form id="form-edit-jenis-inventaris">
                <div class="modal-body pt-0">
                    <div class="card-body">
                        <input id="edit-id" type="hidden" name="edit_id">
                        <div class="form-group">
                            <label for="edit-name">Nama</label>
                            <input type="text" name="edit_name" class="form-control" id="edit-name" placeholder="Masukkan Nama...">
                        </div>
                        <div class="form-group">
                            <label for="edit-desc">Deskripsi</label>
                            <textarea id="edit-desc" name="edit_desc" class="form-control" rows="3" placeholder="Masukkan Deskripsi..."></textarea>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" name="edit_is_active" class="custom-control-input" id="edit-is-active">
                                <label class="custom-control-label" for="edit-is-active">Aktifkan ?</label>
                            </div>
                        </div>
                        <!-- <div class="form-group text-center mb-0">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div> -->
                    </div>
                    <!-- /.card-body -->
                </div>

                <!-- <div id="section-table-added" class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-title">Data yang ingin ditambah</h3>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table id="form_added_data" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th width="10px">#</th>
                                        <th width="200px">Nama</th>
                                        <th>Deskripsi</th>
                                        <th width="120px">Status</th>
                                        <th class="text-center" width="80px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div> -->

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