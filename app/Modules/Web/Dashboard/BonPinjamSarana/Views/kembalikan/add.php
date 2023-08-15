<div class="modal fade" id="modal_add_kembalikan">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah <?=$page_title?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add_kembalikan">
                <div class="modal-body pt-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kode_peminjaman">Kode Peminjaman</label>
                            <input type="text" name="kode_peminjaman" class="form-control" id="kode_peminjaman" placeholder="Masukkan Kode Peminjaman">
                            <button type="button" class="btn btn-info btn-xs"><i class="fas fa-search mr-1"></i>Cari</button>
                        </div>
                        <div class="form-group">
                            <label for="select2_berita_acara">Berita Acara</label>
                            <select id="select2_berita_acara" name="berita_acara" class="form-control select2" style="width: 100%;"></select>
                        </div>
                        <div class="form-group">
                            <label for="record_data_pinjam">Sarana yang akan dikembalikan</label>
                            <textarea style="resize: none;" name="record_data_pinjam" class="form-control" id="record_data_pinjam" cols="20" rows="10" readonly></textarea>
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