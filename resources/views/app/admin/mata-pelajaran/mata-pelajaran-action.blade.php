@if ($action == 'edit')
    <div class="modal fade show" id="modal-viewmapel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Mata Pelajaran</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="{{ route('mata-pelajaran.update', ['mata_pelajaran' => Crypt::encrypt($data->id)]) }}">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mapel" class="col-form-label">Nama Mata Pelajaran</label>
                            <input type="text" class="form-control" id="mapel" name="nama_mapel" required value="{{ $data['nama_mapel'] }}">
                        </div>
                        <div class="form-group">
                            <label for="semester" class="col-form-label">Semester</label>
                            <select name="semester" id="semester" class="form-control">
                                <option value="1" @if ($data['semester'] == 1) selected @endif>1</option>
                                <option value="2" @if ($data['semester'] == 2) selected @endif>2</option>
                                <option value="3" @if ($data['semester'] == 3) selected @endif>3</option>
                                <option value="4" @if ($data['semester'] == 4) selected @endif>4</option>
                                <option value="5" @if ($data['semester'] == 5) selected @endif>5</option>
                                <option value="6" @if ($data['semester'] == 6) selected @endif>6</option>
                            </select>
                        </div> 
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kkm" class="col-form-label">KKM</label>
                            <input type="text" class="form-control" id="kkm" name="kkm" required value={{$data['kkm']}}>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="des_a" class="col-form-label">Deskripsi Nilai A</label>
                            <textarea name="deskripsi_predikat_a" id="des_a" cols="43" rows="5">{{ $data['deskripsi_predikat_A'] }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="des_c" class="col-form-label">Deskripsi Nilai C</label>
                            <textarea name="deskripsi_predikat_c" id="des_c" cols="43" rows="5">{{ $data['deskripsi_predikat_B'] }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="des_b" class="col-form-label">Deskripsi Nilai B</label>
                            <textarea name="deskripsi_predikat_b" id="des_b" cols="43" rows="5">{{ $data['deskripsi_predikat_C'] }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="des_d" class="col-form-label">Deskripsi Nilai D</label>
                            <textarea name="deskripsi_predikat_d" id="des_d" cols="43" rows="5">{{ $data['deskripsi_predikat_D'] }}</textarea>
                        </div>
                    </div>
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
        $("#modal-viewmapel").modal('show');
            $.fn.modal.Constructor.prototype._enforceFocus = function() {
                $(document).off('focusin.bs.modal').on('focusin.bs.modal');
            };
    </script>
@endif
@if ($action == 'hapus')
    <form action="{{route('mata-pelajaran.destroy', ['mata_pelajaran' => Crypt::encrypt($data->id)])}}" method="post">
        @csrf
        @method('DELETE')
        <!-- Modal -->
        <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
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
        $("#delete-modal").modal('show');
    </script>
@endif