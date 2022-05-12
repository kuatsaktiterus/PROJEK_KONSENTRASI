@if ($action == 'edit')
    <div class="modal fade show" id="modal-viewmapel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
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
                <div class="form-group">
                    <label for="mapel" class="col-form-label">Nama Mata Pelajaran</label>
                    <input type="text" class="form-control" id="mapel" name="nama_mapel" value="{{ $data->nama_mapel }}" required>
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