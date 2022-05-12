<?php

namespace App\DataTables\Admin;

use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MataPelajaranDatatable extends DataTable
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
                $action =   '<button type="button" class="waves-effect btn btn-sm btn-danger" onclick="actionmapel(\'' . 'hapus' . '\',\'' . Crypt::encrypt($data->id) . '\')">
                                <i class="fas fa-trash" color=white></i>
                            </button>
                            <button type="button" class="waves-effect btn btn-sm btn-primary" onclick="actionmapel(\'' . 'edit' . '\',\'' . Crypt::encrypt($data->id) . '\')">
                                <i class="fas fa-pen-square" style="color:white;"></i>
                            </button>';
                return $action;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MataPelajaran $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('matapelajarandatatable-table')
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
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin') {
            return [
                'id' => ['title' => 'No', 'orderable' => true, 'searchable' => false, 'render' => function () {
                    return 'function(data,type,fullData,meta){return meta.settings._iDisplayStart+meta.row+1;}';
                }],
                Column::make('nama_mapel')->title('Mata Pelajaran'),
                Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(300)
                    ->addClass('text-center'),
            ];
        } elseif (Auth::user()->role == 'siswa' || Auth::user()->role == 'guru') {
            return [
                'id' => ['title' => 'No', 'orderable' => true, 'searchable' => false, 'render' => function () {
                    return 'function(data,type,fullData,meta){return meta.settings._iDisplayStart+meta.row+1;}';
                }],
                Column::make('nama_mapel')->title('Mata Pelajaran'),
            ];
        }
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Admin/MataPelajaran_' . date('YmdHis');
    }
}
