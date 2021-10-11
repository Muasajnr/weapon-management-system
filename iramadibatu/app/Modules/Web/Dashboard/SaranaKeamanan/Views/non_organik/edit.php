<div class="modal fade" id="modal-edit-senjata-api">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah <?=$page_title?></h4>
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
            <form id="form-edit-senjata-api">
                <div class="modal-body pt-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label id="select2-data-berita-acara">Berita Acara</label>
                            <select id="select2-data-berita-acara" name="edit_berita_acara" class="form-control select2" style="width: 100%;"></select>
                        </div>
                        <div class="form-group">
                            <label for="select2-data-jenis-sarana">Jenis Senjata</label>
                            <select id="select2-data-jenis-sarana" name="edit_jenis_senjata" class="form-control select2" style="width: 100%;"></select>
                        </div>
                        <div class="form-group">
                            <label for="select2-data-merk-sarana">Merk Senjata</label>
                            <select id="select2-data-merk-sarana" name="edit_merk_senjata" class="form-control select2" style="width: 100%;"></select>
                        </div>
                        <div class="form-group">
                            <label for="edit_no_senjata">Nomor Senjata</label>
                            <input type="text" name="edit_no_senjata" class="form-control" id="edit_no_senjata" placeholder="Masukkan Nomor Senjata...">
                        </div>
                        <div class="form-group">
                            <label for="edit_no_bpsa">Nomor BPSA</label>
                            <input type="text" name="edit_no_bpsa" class="form-control" id="edit_no_bpsa" placeholder="Masukkan Nomor BPSA...">
                        </div>
                        <div class="form-group">
                            <label for="edit_kondisi">Kondisi</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="edit_kondisi" value="baik" checked>
                                <label class="form-check-label">Baik</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="edit_kondisi" value="rusak">
                                <label class="form-check-label">Rusak</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_media_senjata">Unggah File ( .png | .jpeg ) , Max : <strong>500KB</strong></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="edit_media_senjata" class="custom-file-input" id="edit_media_senjata">
                                    <label class="custom-file-label" for="edit_media_senjata">Pilih file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_keterangan">Keterangan</label>
                            <textarea id="edit_keterangan" name="edit_keterangan" class="form-control" rows="3" placeholder="Masukkan Keterangan..."></textarea>
                        </div>
                        <div class="form-group text-center mb-0">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
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
                </div> -->

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <!-- <button id="btn-submit-all" type="button" class="btn btn-primary">Submit</button> -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>