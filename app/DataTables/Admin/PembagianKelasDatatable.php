<?php

namespace App\DataTables\Admin;

use App\Models\PembagianKelas;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PembagianKelasDatatable extends DataTable
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
                $action =   '<form action="/app/pembagian-kelas-siswa/' . Crypt::encrypt($data->id)  . '"  method="get">
                                <button type="button" class="waves-effect btn btn-sm btn-danger" onclick="actionpembagiankelas(\'' . 'hapus' . '\',\'' . Crypt::encrypt($data->id) . '\')">
                                    <i class="fas fa-trash" color=white></i>
                                </button>
                                <button type="submit" class="waves-effect btn btn-sm btn-success">
                                    <i class="far fa-eye" style="color:white !important;"></i>
                                </button>
                                <button type="button" class="waves-effect btn btn-sm btn-primary" onclick="actionpembagiankelas(\'' . 'edit' . '\',\'' . Crypt::encrypt($data->id) . '\')">
                                    <i class="fas fa-pen-square" style="color:white;"></i>
                                </button>
                            </form>';
                return $action;
            })
            ->addColumn('wali_kelas', function ($data) {
                $wali_kelas = PembagianKelas::find($data->id);
                return $wali_kelas->guru->nip . ' - ' . $wali_kelas->guru->nama;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Admin/PembagianKelasDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PembagianKelas $model)
    {
        return $model->newQuery()->where('id_kelas', $this->id);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('pembagiankelasdatatable-table')
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
            Column::make('nama_kelas')->title('Nama Kelas'),
            Column::make('wali_kelas')->title('Wali Kelas'),
            Column::computed('action')
                ->exportable(FALSE)
                ->printable(FALSE)
                ->width(500)
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
        return 'Admin/PembagianKelas_' . date('YmdHis');
    }
}
