<div class="modal fade" id="modal_add_distribusi">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Distribusi Sarana</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add_distribusi">
                <div class="modal-body pt-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Berita Acara</label>
                            <select id="select2-data-berita-acara" name="berita_acara" class="form-control select2" style="width: 100%;"></select>
                        </div>
                        <div class="form-group">
                            <div class="mb-2">
                                <strong>Pilih Senjata</strong>
                            </div>
                            <table class="table table-sm table-border">
                                <thead style="display:table; width: 100%; table-layout:fixed;" class="thead-dark">
                                    <tr>
                                        <th>No. Senjata</th>
                                        <th>Nama Sarana</th>
                                        <th>Jumlah</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody style="display: block; white-space: nowrap; height: 250px; overflow-y: auto;">
                                    <?php for($i = 0; $i < 50; $i++): ?>
                                        <tr style="display:table; width:100%; table-layout:fixed;">
                                            <td>123456789</td>
                                            <td>Sniper - Merk</td>
                                            <td>
                                                <div>
                                                    <input type="text" class="mr-1" value="1">
                                                    <strong>of 5</strong>
                                                </div>
                                            </td>
                                            <td><button type="button" class="btn btn-primary btn-sm">Pinjam</button></td>
                                        </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <label for="record_data_pinjam">Sarana yang akan didistribusi</label>
                            <textarea style="resize: none;" name="record_data_pinjam" class="form-control" id="record_data_pinjam" cols="20" rows="10" readonly></textarea>
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi Distribusi</label>
                            <input type="text" name="lokasi" class="form-control" id="lokasi" placeholder="Lokasi distribusi...">
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