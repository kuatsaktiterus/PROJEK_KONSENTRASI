@if ($action == 'hapus')
<form action="{{ route('jadwal-kelas.destroy', ['jadwal_kela' => Crypt::encrypt($data->id)]) }}" method="post">
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
<?php
\Carbon\Carbon::setLocale('id_ID');
$weekdays = \Carbon\Carbon::getDays();
?>
@if ($action == 'edit')
    <!-- Modal -->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Kategori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form method="POST" action="{{ route('jadwal-kelas.update', ['jadwal_kela' => Crypt::encrypt($data->id)]) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="pembagian_kelas" value='{{$data->pembagiankelas->id}}'>
                <div class="form-group">
                <label for="mapel" class="col-form-label">Mata Pelajaran</label>
                    <select name="mapel" class="form-control" id="mapel_edit" required>
                        <option value="">-- Pilih salah satu mata pelajaran  --</option>
                        @foreach ($matapelajaran as $matapelajaran)
                        <option value="{{$matapelajaran->id}}" @if($data->id_matapelajaran == $matapelajaran->id) selected @endif>{{$matapelajaran->nama_mapel}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                <label for="pengajar" class="col-form-label">Pengajar</label>
                    <select name="pengajar" class="form-control" id="pengajar_edit" required>
                        <option value="">-- Pilih salah satu guru untuk menjadi pengajar  --</option>
                        @foreach ($pengajar as $pengajar)
                        <option value="{{$pengajar->id}}" @if($data->id_pengajar == $pengajar->id) selected @endif>{{$pengajar->nip}} - {{$pengajar->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                <label for="jadwal" class="col-form-label">Jadwal</label>
                    <select name="jadwal" class="form-control" id="jadwal_edit" required>
                        <option value="">-- Pilih salah satu jam mata pelajaran  --</option>
                        @foreach ($jadwal as $jadwal)
                        <option value="{{$jadwal->id}}" @if($data->id_jadwal == $jadwal->id) selected @endif>Hari = {{ \Carbon\Carbon::create($weekdays[$jadwal->hari])->dayName; }} Jam Mulai = {{$jadwal->jam_mulai}} Jam Selesai = {{$jadwal->jam_selesai}}</option>
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
    $('#pembagian_kelas_edit').chosen({ width: '100%' });
    $('#mapel_edit').chosen({ width: '100%' });
    $('#pengajar_edit').chosen({ width: '100%' });
    $('#jadwal_edit').chosen({ width: '100%' });
    $("#edit_modal").modal('show');
</script>
@endif
