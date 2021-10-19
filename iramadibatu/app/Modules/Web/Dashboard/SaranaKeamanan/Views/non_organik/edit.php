<div class="modal fade" id="modal-edit-non-organik">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit <?=$page_title?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit-non-organik">
                <div class="modal-body pt-0">
                    <div class="card-body">
                        <input type="hidden" name="edit_id">
                        <div class="form-group">
                            <label for="select2-data-berita-acara-edit">Berita Acara</label>
                            <select id="select2-data-berita-acara-edit" name="edit_berita_acara" class="form-control select2" style="width: 100%;"></select>
                        </div>
                        <div class="form-group">
                            <label for="select2-data-jenis-sarana-edit">Jenis Senjata</label>
                            <select id="select2-data-jenis-sarana-edit" name="edit_jenis_senjata" class="form-control select2" style="width: 100%;"></select>
                        </div>
                        <div class="form-group">
                            <label for="select2-data-merk-sarana-edit">Merk Senjata</label>
                            <select id="select2-data-merk-sarana-edit" name="edit_merk_senjata" class="form-control select2" style="width: 100%;"></select>
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
                        <div class="row">
                            <div class="col-6">
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
                            </div>
                            <div class="col-6">
                                <label for="">Media Saat Ini : </label>
                                <div class="media-area"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_keterangan">Keterangan</label>
                            <textarea id="edit_keterangan" name="edit_keterangan" class="form-control" rows="3" placeholder="Masukkan Keterangan..."></textarea>
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