<?php

namespace App\DataTables\Admin;

use App\Models\Guru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class GuruDatatable extends DataTable
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
                $action =   '
                                <button  class="waves-effect btn btn-sm btn-danger" onclick="actionguru(\'' . Crypt::encrypt($data->id) . '\')">
                                    <i class="fas fa-trash" color=white></i>
                                </button>
                                <a  class="btn btn-sm btn-success" href="'. route('guru.show', ['guru' => Crypt::encrypt($data->id)]) .'"
                                    onclick="event.preventDefault();
                                    document.getElementById("show-form").submit();"
                                    >
                                    <i class="far fa-eye" style="color:white !important;"></i>
                                </a>
                                <a class="waves-effect btn btn-sm btn-primary" href="'. route('guru.edit', ['guru' => Crypt::encrypt($data->id)]).'"
                                    onclick="event.preventDefault();
                                    document.getElementById("edit-form").submit();"
                                    >
                                    <i class="fas fa-pen-square" style="color:white;"></i>
                                </a>

                                <form id="show-form" action="'. route('guru.show', ['guru' => Crypt::encrypt($data->id)]) . '" method="GET" class="d-none">
                                </form>
                                <form id="edit-form" action="'. route('guru.edit', ['guru' => Crypt::encrypt($data->id)]) . '" method="GET" class="d-none">
                                </form>';
                return $action;
            })
            ->addColumn('foto', function ($data) {
                $file = "storage/image/guru/" . $data->foto;
                return '<img class="mg-thumbnail" width="80" src="' . asset($file) . '">';
            })
            ->rawColumns(['foto', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Guru $model)
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
                    ->setTableId('gurudatatable-table')
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
                'id' => ['title' => 'No', 'orderable' => false, 'searchable' => false, 'render' => function () {
                    return 'function(data,type,fullData,meta){return meta.settings._iDisplayStart+meta.row+1;}';
                }],
                Column::make('foto'),
                Column::make('nip')->title('NIP'),
                Column::make('nama'),
                Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(500)
                    ->addClass('text-center'),
            ];
        } elseif (Auth::user()->role == 'siswa') {
            return [
                'id' => ['title' => 'No', 'orderable' => false, 'searchable' => false, 'render' => function () {
                    return 'function(data,type,fullData,meta){return meta.settings._iDisplayStart+meta.row+1;}';
                }],
                Column::make('foto'),
                Column::make('nama'),
                Column::make('no_telepon')->title('No.HP'),
                Column::make('nip')->title('NIP'),
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
        return 'Admin/Guru_' . date('YmdHis');
    }
}
