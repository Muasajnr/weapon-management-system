<div class="modal fade" id="modal-edit-penanggung-jawab">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Penanggung Jawab</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit-penanggung-jawab">
                <div class="modal-body pt-0">
                    <div class="card-body">
                        <input type="hidden" name="edit_id" id="edit_id">
                        <div class="form-group">
                            <label class="text-sm" for="edit_nama">Nama Lengkap (<span class="text-danger">*</span>)</label>
                            <input type="text" name="edit_nama" class="form-control form-control-sm" id="edit_nama" placeholder="Nama Lengkap">
                        </div>
                        <div class="form-group">
                            <label class="text-sm" for="edit_nip">NIP (<span class="text-danger">*</span>)</label>
                            <input type="text" name="edit_nip" class="form-control form-control-sm" id="edit_nip" placeholder="NIP">
                        </div>
                        <div class="form-group">
                            <label class="text-sm" for="edit_pangkat_golongan">Pangkat/Golongan (<span class="text-danger">*</span>)</label>
                            <input type="text" name="edit_pangkat_golongan" class="form-control form-control-sm" id="edit_pangkat_golongan" placeholder="Pangkat/Golongan">
                        </div>
                        <div class="form-group">
                            <label class="text-sm" for="edit_jabatan">Jabatan (<span class="text-danger">*</span>)</label>
                            <input type="text" name="edit_jabatan" class="form-control form-control-sm" id="edit_jabatan" placeholder="Jabatan">
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