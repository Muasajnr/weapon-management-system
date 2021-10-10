<div class="modal fade" id="modal-add-senjata-api">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah <?=$page_title?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-0">
                <div class="card-body pb-0 pt-0 text-right">
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                        <input type="checkbox" name="is_single_insert" class="custom-control-input" id="is_single_insert" disabled>
                        <label class="custom-control-label" for="is_single_insert">Single-Insert</label>
                    </div>
                </div>
            </div>
            <form id="form-add-senjata-api">
                <div class="modal-body pt-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Berita Acara</label>
                            <select id="select2-data-berita-acara" name="berita_acara" class="form-control select2" style="width: 100%;"></select>
                        </div>
                        <div class="form-group">
                            <label>Jenis Senjata</label>
                            <select id="select2-data-jenis-sarana" name="jenis_senjata" class="form-control select2" style="width: 100%;"></select>
                        </div>
                        <div class="form-group">
                            <label>Merk Senjata</label>
                            <select id="select2-data-merk-sarana" name="merk_senjata" class="form-control select2" style="width: 100%;"></select>
                        </div>
                        <div class="form-group">
                            <label for="no_senjata">Nomor Senjata</label>
                            <input type="text" name="no_senjata" class="form-control" id="no_senjata" placeholder="Masukkan Nomor Senjata...">
                        </div>
                        <div class="form-group">
                            <label for="no_bpsa">Nomor BPSA</label>
                            <input type="text" name="no_bpsa" class="form-control" id="no_bpsa" placeholder="Masukkan Nomor BPSA...">
                        </div>
                        <div class="form-group">
                            <label for="kondisi">Kondisi</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="kondisi" value="baik" checked>
                                <label class="form-check-label">Baik</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="kondisi" value="rusak">
                                <label class="form-check-label">Rusak</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="media_senjata">Unggah File ( .png | .jpeg ) , Max : <strong>500KB</strong></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="media_senjata" class="custom-file-input" id="media_senjata">
                                    <label class="custom-file-label" for="media_senjata">Pilih file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea id="keterangan" name="keterangan" class="form-control" rows="3" placeholder="Masukkan Keterangan..."></textarea>
                        </div>
                        <div class="form-group text-center mb-0">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>

                <div id="section-table-added" class="modal-body">
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
                                        <th>No. Senjata</th>
                                        <th>No. BPSA</th>
                                        <th>Jenis Senjata</th>
                                        <th>Merk Senjata</th>
                                        <th class="text-center" width="80px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button id="btn-submit-all" type="button" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>