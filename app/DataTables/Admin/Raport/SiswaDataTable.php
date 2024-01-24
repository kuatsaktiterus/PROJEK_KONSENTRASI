<?php

namespace App\DataTables\Admin\Raport;

use App\Models\Siswa;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SiswaDataTable extends DataTable
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
                                <a  class="btn btn-sm btn-success" href="'. route('nilai-semester-list-raport.index', ['id' => Crypt::encrypt($data->id)]) .'"
                                    onclick="event.preventDefault();
                                    document.getElementById("show-form").submit();"
                                    >
                                    <i class="far fa-eye" style="color:white !important;"></i>
                                </a>

                                <form id="show-form" action="'. route('nilai-semester-list-raport.index', ['id' => Crypt::encrypt($data->id)]) . '" method="GET" class="d-none">
                                </form>';
                return $action;
            })
            ->addColumn('foto', function ($data) {
                $file = "image/siswa/" . $data->foto;
                return '<img class="mg-thumbnail" width="80" src="' . asset("/storage/$file") . '">';
            })
            ->rawColumns(['foto', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Siswa $model)
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
                    ->setTableId('siswa-table')
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
            Column::make('foto')
                ->title('Foto')
                ->orderable(false),
            Column::make('nisn')->title('NISN'),
            Column::make('name')
                ->title('Nama Lengkap')
                ->width(500)
                ->addClass('text-center'),
            Column::make('jenis_kelamin'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
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
        return 'Raport/Siswa_' . date('YmdHis');
    }
}
