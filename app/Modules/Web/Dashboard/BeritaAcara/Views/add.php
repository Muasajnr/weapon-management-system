<div class="modal fade" id="modal-add-berita-acara">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah <?=$page_title?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-add-berita-acara">
                <div class="modal-body pt-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nomor">No. Berita Acara</label>
                            <input type="text" name="nomor" class="form-control" id="nomor" placeholder="Nomor">
                        </div>
                        <div class="form-group">
                            <label for="nama">Judul</label>
                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Judul">
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal:</label>
                            <div class="input-group date" id="tanggal" data-target-input="nearest">
                                <input type="text" name="tanggal" class="form-control datetimepicker-input" data-target="#tanggal"/>
                                <div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Pihak 1</label>
                            <select id="select2-data-pihak-1" name="pihak_1" class="form-control select2" style="width: 100%;"></select>
                        </div>
                        <div class="form-group">
                            <label>Pihak 2</label>
                            <select id="select2-data-pihak-2" name="pihak_2" class="form-control select2" style="width: 100%;"></select>
                        </div>
                        <div class="form-group">
                            <label for="media">Unggah File ( .png | .jpeg | .pdf ) , Max : <strong>500KB</strong></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="media" class="custom-file-input" id="media">
                                    <label class="custom-file-label" for="media">Pilih file</label>
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