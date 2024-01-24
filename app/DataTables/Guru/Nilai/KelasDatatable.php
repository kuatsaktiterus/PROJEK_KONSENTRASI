<?php

namespace App\DataTables\Guru\Nilai;

use App\Models\JadwalKelas;
use App\Models\PembagianKelas;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KelasDatatable extends DataTable
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
            ->addColumn('kelas', function ($data) {
                return "Kelas ".$data->pembagiankelas->kelas->kelas." ".$data->pembagiankelas->kelas->jurusan->jurusan." " .$data->pembagiankelas->nama_kelas."";
            })
            ->addColumn('action', function ($data){
                $action =   '
                            <a  class="btn btn-sm btn-success" href="'. route('nilai-siswa-siswa.show', ['id' => Crypt::encrypt($data->id)]) .'"
                                onclick="event.preventDefault();
                                document.getElementById("show-form").submit();"
                                >
                                <i class="far fa-eye" style="color:white !important;"></i>
                            </a>

                            <form id="show-form" action="'. route('nilai-siswa-siswa.show', ['id' => Crypt::encrypt($data->id)]) . '" method="GET" class="d-none">
                            </form>';
                return $action;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(JadwalKelas $model)
    {
        return $model->newQuery()->where("id_matapelajaran", $this->id);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('kelasdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
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
            Column::make('kelas')->title('Kelas'),
            Column::make('action')->title('Action'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Guru/Nilai/Kelas_' . date('YmdHis');
    }
}
