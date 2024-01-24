<?php

namespace App\DataTables\Admin;

use App\Models\Siswa;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class IsiKelasDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) {
                $action =  '<form method="POST" action="'. route('pembagian-kelas-siswa.destroy', ['pembagian_kelas_siswa' => Crypt::encrypt($data->pembagiankelassiswa[0]->id), 'idSiswa' => Crypt::encrypt($data->id)]).'">
                                <input type="hidden" name="_token" value='.csrf_token().'>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="waves-effect btn btn-danger">
                                    Keluarkan    <i class="fas fa-sign-out-alt fa-flip-horizontal"></i>
                                </button>
                            </form>';
                return $action;
            })
            ->addColumn('gambar', function ($data) {
                $file = "image/siswa/" . $data->foto;
                return '<img class="mg-thumbnail" width="80" src="' . asset("storage/$file") . '">';
            })
            ->rawColumns(['gambar', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Siswa $model)
    {
        return $model->newQuery()->whereHas('pembagiankelassiswa', function ($q) {
            $q->where('id_pembagian_kelas', $this->id);
        }, '>=', 1);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('isikelasdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['title' => 'No', 'orderable' => false, 'searchable' => false, 'render' => function () {
                return 'function(data,type,fullData,meta){return meta.settings._iDisplayStart+meta.row+1;}';
            }],
            Column::make('gambar')->title('Foto'),
            Column::make('nisn')->title('NISN'),
            Column::make('name')
                ->title('Nama Lengkap')
                ->width(500)
                ->addClass('text-center'),
            Column::make('jenis_kelamin'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(300)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Admin/IsiKelas_' . date('YmdHis');
    }
}
