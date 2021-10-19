<div class="modal fade" id="modal-edit-lainnya">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah <?=$page_title?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit-lainnya">
                <div class="modal-body pt-0">
                    <div class="card-body">
                        <input type="hidden" name="edit_id">
                        <div class="form-group">
                            <label>Berita Acara</label>
                            <select id="select2-data-berita-acara-edit" name="edit_berita_acara" class="form-control select2" style="width: 100%;"></select>
                        </div>
                        <div class="form-group">
                            <label for="edit_nama">Nama</label>
                            <input type="text" name="edit_nama" class="form-control" id="edit_nama" placeholder="Nama">
                        </div>
                        <div class="form-group">
                            <label for="edit_jumlah">Jumlah</label>
                            <input type="number" name="edit_jumlah" class="form-control" id="edit_jumlah" placeholder="Jumlah">
                        </div>
                        <div class="form-group">
                            <label for="edit_satuan">Satuan</label>
                            <select id="edit_satuan" name="edit_satuan" class="form-control" style="width: 100%;">
                                <option value="buah">Buah</option>
                                <option value="unit">Unit</option>
                            </select>
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
                                    <label for="edit_media">Unggah File ( .png | .jpeg ) , Max : <strong>500KB</strong></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="edit_media" class="custom-file-input" id="edit_media">
                                            <label class="custom-file-label" for="edit_media">Pilih file</label>
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
                            <textarea id="edit_keterangan" name="edit_keterangan" class="form-control" rows="3" placeholder="Keterangan"></textarea>
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