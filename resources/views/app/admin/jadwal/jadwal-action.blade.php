@if ($action == 'hapus')
<form action="{{ route('jadwal.destroy', ['jadwal' => Crypt::encrypt($data->id)]) }}" method="post">
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
        <h5 class="modal-title" id="exampleModalLabel">Edit Jadwal Sekolah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form method="POST" action="{{ route('jadwal.update', ['jadwal' => Crypt::encrypt($data->id)]) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <center>
                    <label for="jam_mulai" class="col-form-label">Jam Mulai</label>
                    <input type="time" class="form-control w-75" id="jam_mulai" required name="jam_mulai" value="{{$data->jam_mulai}}">
                </center>
            </div>
            <div class="form-group">
                <center>
                    <label for="jam_selesai" class="col-form-label">Jam Selesai</label>
                    <input type="time" class="form-control w-75" id="jam_selesai" required name="jam_selesai" value="{{$data->jam_selesai}}">
                </center>
            </div>
            <div class="form-group">
                <center>
                    <label for="hari" class="col-form-label">Hari</label>
                    <select name="hari" id="hari" class="form-control w-75" required>
                        <option value="">--    Pilih Salah Satu    --</option>
                        <option value="1" @if($data->hari == 1) selected @endif>Senin</option>
                        <option value="2" @if($data->hari == 2) selected @endif>Selasa</option>
                        <option value="3" @if($data->hari == 3) selected @endif>Rabu</option>
                        <option value="4" @if($data->hari == 4) selected @endif>Kamis</option>
                        <option value="5" @if($data->hari == 5) selected @endif>Jumat</option>
                        <option value="6" @if($data->hari == 6) selected @endif>Sabtu</option>
                        <option value="0" @if($data->hari == 0) selected @endif>Minggu</option>
                    </select>
                </center>
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
    $("#edit_modal").modal('show');
</script>
@endif
