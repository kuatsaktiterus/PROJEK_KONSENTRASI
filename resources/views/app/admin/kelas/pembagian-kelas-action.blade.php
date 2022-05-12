@if ($action == 'hapus')
<form action="{{ route('pembagian-kelas.destroy', ['pembagian_kela' => Crypt::encrypt($data->id)]) }}" method="post">
    @csrf
    @method('DELETE')

    <!-- Modal -->
    <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus data ini ?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $("#delete_modal").modal('show');
</script>
@endif

@if ($action == 'edit')
    <!-- Modal -->
<div class="modal fade show" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Data Kelas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form method="POST" action="{{ route('pembagian-kelas.update', ['pembagian_kela' => Crypt::encrypt($data->id)]) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
            <label for="kelas" class="col-form-label">Nama Kelas</label>
            <input type="text" class="form-control" id="kelas" name="nama_kelas" value="{{ $data->nama_kelas }}" required>
            </div>
            <div class="form-group">
                <label for="wali_kelas" class="col-form-label">Wali kelas</label>
                <select name="wali_kelas" id="wali_kelas_edit" class="form-control">
                    @foreach ($gurus as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->nip }} - {{ $guru->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        </div>

    </div>
    </div>
</div>
<script>
    $('#wali_kelas_edit').chosen({ width: '100%' });
    $("#edit_modal").modal('show');
</script>
@endif
