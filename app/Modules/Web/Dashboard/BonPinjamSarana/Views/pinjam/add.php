<div class="modal fade" id="modal_add_pinjam">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Pinjam Sarana</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add_pinjam">
                <div class="modal-body pt-0">
                    <div class="card-body">
                        <input type="hidden" name="nomor_peminjaman" id="nomor_peminjaman">
                        <div class="form-group">
                            <label for="kode_peminjaman">Kode Peminjaman</label>
                            <input type="text" class="form-control" name="kode_peminjaman" id="kode_peminjaman" readonly>
                        </div>
                        <div class="form-group">
                            <label>Berita Acara</label>
                            <select id="select2-data-berita-acara" name="berita_acara" class="form-control select2" style="width: 100%;"></select>
                        </div>
                        <div class="form-group">
                            <div class="mb-2">
                                <strong>Pilih Senjata</strong>
                            </div>
                            <table id="data_choose_pinjam" class="table table-sm table-border">
                                <thead style="display:table; width: 100%; table-layout:fixed;" class="thead-dark">
                                    <tr>
                                        <th width="40px">No.</th>
                                        <th width="120px">No. Senjata</th>
                                        <th>Tipe</th>
                                        <th>Nama & Merk</th>
                                        <th>Jumlah</th>
                                        <th width="100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody style="display: block; white-space: nowrap; height: 250px; overflow-y: auto;"></tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <label>Sarana yang akan dipinjam</label>
                            <textarea style="resize: none;" name="record_data_pinjam" class="form-control mb-1" cols="20" rows="10" readonly></textarea>
                            <button type="button" class="btn btn-danger btn-xs">Clear</button>
                        </div>
                        <input type="hidden" name="ids_pinjam">
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