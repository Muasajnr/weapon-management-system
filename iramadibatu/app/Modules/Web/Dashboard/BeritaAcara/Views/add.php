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
                            <input type="text" name="nomor" class="form-control" id="nomor" placeholder="Masukkan Nomor...">
                        </div>
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" name="judul" class="form-control" id="judul" placeholder="Masukkan Judul...">
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
                        <div class="form-group mb-5 mt-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Pihak 1</strong>
                                    <hr>
                                    <div class="form-group">
                                        <label for="pihak_1_nama">Nama</label>
                                        <input type="text" name="pihak_1_nama" class="form-control" id="pihak_1_nama" placeholder="Nama...">
                                    </div>
                                    <div class="form-group">
                                        <label for="pihak_1_nip">NIP</label>
                                        <input type="text" name="pihak_1_nip" class="form-control" id="pihak_1_nip" placeholder="NIP...">
                                    </div>
                                    <div class="form-group">
                                        <label for="pihak_1_pangkat">Pangkat/Golongan</label>
                                        <input type="text" name="pihak_1_pangkat" class="form-control" id="pihak_1_pangkat" placeholder="Pangkat/Golongan...">
                                    </div>
                                    <div class="form-group">
                                        <label for="pihak_1_jabatan">Jabatan</label>
                                        <input type="text" name="pihak_1_jabatan" class="form-control" id="pihak_1_jabatan" placeholder="Jabatan...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <strong>Pihak 2</strong>
                                    <hr>
                                    <div class="form-group">
                                        <label for="pihak_2_nama">Nama</label>
                                        <input type="text" name="pihak_2_nama" class="form-control" id="pihak_2_nama" placeholder="Nama...">
                                    </div>
                                    <div class="form-group">
                                        <label for="pihak_2_nip">NIP</label>
                                        <input type="text" name="pihak_2_nip" class="form-control" id="pihak_2_nip" placeholder="NIP...">
                                    </div>
                                    <div class="form-group">
                                        <label for="pihak_2_golongan">Pangkat/Golongan</label>
                                        <input type="text" name="pihak_2_pangkat" class="form-control" id="pihak_2_pangkat" placeholder="Pangkat/Golongan...">
                                    </div>
                                    <div class="form-group">
                                        <label for="pihak_2_jabatan">Jabatan</label>
                                        <input type="text" name="pihak_2_jabatan" class="form-control" id="pihak_2_jabatan" placeholder="Jabatan...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="media">Unggah File ( .png | .jpeg ) , Max : <strong>500KB</strong></label>
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
                            <textarea id="keterangan" name="keterangan" class="form-control" rows="3" placeholder="Keterangan..."></textarea>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>

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