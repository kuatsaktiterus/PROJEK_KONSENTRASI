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
        <form method="POST" action="{{ route('change-pass-superadmin.put', ['id' => Auth()->user()->id]) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="password" class="col-form-label">Password lama</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Isikan password lama anda">
            </div>
            <div class="form-group">
                <label for="passwordBaru" class="col-form-label">Password baru</label>
                <input type="password" class="form-control" id="passwordBaru" name="newPassword" placeholder="Isikan password baru, minimal 8 karakter">
            </div>
            <div class="form-group">
                <label for="konfirmasiPassword" class="col-form-label">Konfirmasi Password baru</label>
                <input type="password" class="form-control" id="konfirmasiPassword" name="konfirmasiPassword" placeholder="Isikan password baru, minimal 8 karakter">
            </div>
            <div class="modal-footer">
            <small>
                <p>* Untuk keamanan password harus setidaknya terdiri dari 8 karakter, huruf besar dan kecil, angka, serta simbol</p>
            </small>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        </div>
        
    </div>
    </div>
</div>