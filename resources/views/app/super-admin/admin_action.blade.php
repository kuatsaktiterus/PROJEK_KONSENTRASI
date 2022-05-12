@if ($action == 'hapus')
<form action="{{ route('admin.destroy', ['admin' => Crypt::encrypt($data->id)]) }}" method="post">
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
        <h5 class="modal-title" id="exampleModalLabel">Edit Data Admin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form method="POST" action="{{ route('admin.update', ['admin' => Crypt::encrypt($data->id)]) }}">
            @csrf
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="nama" class="col-form-label">Nama</label>
                <input type="text" class="form-control" id="nama" placeholder="Admin A" required name="nama" value="{{ $data->nama }}">
            </div>
            <div class="form-group">
                <label for="username" class="col-form-label">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Admin A" name="username" value="{{ $data->user->username }}">
            </div>
            <div class="form-group">
                <label for="password" class="col-form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <small>
                <p>* Untuk keamanan password harus setidaknya terdiri dari 8 karakter, huruf besar dan kecil, angka, serta simbol</p>
            </small>
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
    $("#edit_modal").modal('show');
</script>
@endif