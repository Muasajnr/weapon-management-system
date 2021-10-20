<div class="modal fade" id="modal-add-lainnya">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah <?=$page_title?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-add-lainnya">
                <div class="modal-body pt-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Berita Acara</label>
                            <select id="select2-data-berita-acara" name="berita_acara" class="form-control select2" style="width: 100%;"></select>
                            <a href="<?=route_to('berita_acara')?>">Buat baru</a>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama">
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" id="jumlah" placeholder="Jumlah">
                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <select id="satuan" name="satuan" class="form-control" style="width: 100%;">
                                <option value="buah">Buah</option>
                                <option value="Unit">Unit</option>
                            </select>
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
                            <textarea id="keterangan" name="keterangan" class="form-control" rows="3" placeholder="Keterangan"></textarea>
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