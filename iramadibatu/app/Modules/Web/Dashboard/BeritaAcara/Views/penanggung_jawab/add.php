<div class="modal fade" id="modal-add-penanggung-jawab">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Penanggung Jawab</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-add-penanggung-jawab">
                <div class="modal-body pt-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="text-sm" for="nama">Nama Lengkap (<span class="text-danger">*</span>)</label>
                            <input type="text" name="nama" class="form-control form-control-sm" id="nama" placeholder="Nama Lengkap">
                        </div>
                        <div class="form-group">
                            <label class="text-sm" for="nip">NIP (<span class="text-danger">*</span>)</label>
                            <input type="text" name="nip" class="form-control form-control-sm" id="nip" placeholder="NIP">
                        </div>
                        <div class="form-group">
                            <label class="text-sm" for="pangkat_golongan">Pangkat/Golongan (<span class="text-danger">*</span>)</label>
                            <input type="text" name="pangkat_golongan" class="form-control form-control-sm" id="pangkat_golongan" placeholder="Pangkat/Golongan">
                        </div>
                        <div class="form-group">
                            <label class="text-sm" for="jabatan">Jabatan (<span class="text-danger">*</span>)</label>
                            <input type="text" name="jabatan" class="form-control form-control-sm" id="jabatan" placeholder="Jabatan">
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