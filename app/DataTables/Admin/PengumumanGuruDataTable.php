<?php

namespace App\DataTables\Admin;

use App\Models\PengumumanGuru;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PengumumanGuruDataTable extends DataTable
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
                if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin') {
                    $action = '<button  class="waves-effect btn btn-sm btn-danger" onclick="actionpengumuman(\'' . Crypt::encrypt($data->id) . '\')">
                                <i class="fas fa-trash" color=white></i>
                            </button>';
                return $action;
                }
                $action = '<button  class="waves-effect btn btn-sm btn-danger" onclick="actionpengumuman(\'' . 'hapus' . '\',\'' . Crypt::encrypt($data->id) . '\')">
                                <i class="fas fa-trash" color=white></i>
                            </button>
                            <button class="waves-effect btn btn-sm btn-primary" onclick="actionpengumuman(\'' . 'edit' . '\',\'' . Crypt::encrypt($data->id) . '\')">
                                <i class="fas fa-pen-square" ></i>
                            </button>';
                return $action;
            })
            ->addColumn('waktu_pengumuman', function ($data) {
                $waktu = Carbon::parse($data->waktu_pengumuman);
                return $waktu->format('d/m/Y');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PengumumanGuru $model)
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin') {
            return $model->newQuery();
        }
        return $model->newQuery()->where('id_guru', $this->id);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('pengumumanguru-table')
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
            Column::make('pengumuman'),
            Column::make('waktu_pengumuman'),
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
        return 'Admin/PengumumanGuru_' . date('YmdHis');
    }
}
