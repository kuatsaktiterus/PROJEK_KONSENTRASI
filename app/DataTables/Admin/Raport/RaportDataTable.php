<?php

namespace App\DataTables\Admin\Raport;

use App\Models\Raport;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RaportDataTable extends DataTable
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
                                <a  class="btn btn-sm btn-success" href="'. route('nilai-semester-raport.index', ['id' => Crypt::encrypt($data->id), 'idSiswa' => Crypt::encrypt($this->id)]) .'"
                                    onclick="event.preventDefault();
                                    document.getElementById("show-form").submit();"
                                    >
                                    <i class="far fa-eye" style="color:white !important;"></i>
                                </a>

                                <form id="show-form" action="'. route('nilai-semester-raport.index', ['id' => Crypt::encrypt($data->id), 'idSiswa' => Crypt::encrypt($this->id)]) . '" method="GET" class="d-none">
                                </form>';
                return $action;
            })
            ->addColumn('semester', function($data) {
                return ucfirst($data->ArsipRekapitulasiKelas->tahunajaran->semester);
            })
            ->addColumn('tahun_ajaran', function($data) {
                $tahunAjaran = $data->ArsipRekapitulasiKelas->tahunajaran->tahun_ajar_awal . "/" . $data->ArsipRekapitulasiKelas->tahunajaran->tahun_ajar_akhir;
                return $tahunAjaran;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Raport $model)
    {
        return $model->newQuery()->where('id_siswa', $this->id);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('raport-table')
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
            Column::make('semester')->title('Semester'),
            Column::make('tahun_ajaran')->title('Tahun Ajaran'),
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
        return 'Admin/Raport/Raport_' . date('YmdHis');
    }
}
