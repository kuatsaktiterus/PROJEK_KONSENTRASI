<?php

namespace App\DataTables\Admin;

use App\Models\Jurusan;
use App\Models\Siswa;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PembagianKelasSiswaDatatable extends DataTable
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
                $action = "<form method='POST' action='". url('/app/pembagian-kelas-siswa/'.Crypt::encrypt($data->id).'/'.Crypt::encrypt($this->id)) ."'>
                                <input type='hidden' name='_token' value=".csrf_token().">
                                <button type='submit' class='waves-effect btn btn-primary'>
                                    Masukkan <i class='fas fa-sign-in-alt'></i>
                                </button>
                            </form>";
                return $action;
            })
            ->addColumn('gambar', function ($data) {
                $file = "/image/siswa/" . $data->foto;
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
        $jurusan = Jurusan::find($this->id_jurusan);
        return $model->newQuery()->whereHas('pembagiankelassiswa', function () {
            Siswa::has('pembagiankelassiswa');
        }, '<', 1)->where('id_jurusan', $jurusan->id);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('pembagiankelassiswadatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->autoWidth(false);
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
            Column::make('name'),
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
        return 'Admin/PembagianKelasSiswa_' . date('YmdHis');
    }
}
