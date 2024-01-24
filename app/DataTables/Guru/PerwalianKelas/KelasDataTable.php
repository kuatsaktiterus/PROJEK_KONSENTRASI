<?php

namespace App\DataTables\Guru\PerwalianKelas;

use App\Models\PembagianKelas;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KelasDataTable extends DataTable
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
            ->addColumn('nama_kelas', function($data)
            {
                return $data->Kelas->kelas . " " . $data->kelas->jurusan->jurusan . " " . $data->nama_kelas;
            })
            ->addColumn('action', function($data)
            {
                $action =   '
                            <a  class="btn btn-sm btn-success" href="'. route('perwalian-kelas-siswa.index', ['id' => Crypt::encrypt($data->id)]) .'"
                                onclick="event.preventDefault();
                                document.getElementById("show-form").submit();"
                                >
                                <i class="far fa-eye" style="color:white !important;"></i>
                            </a>

                            <form id="show-form" action="'. route('perwalian-kelas-siswa.index', ['id' => Crypt::encrypt($data->id)]) . '" method="GET" class="d-none">
                            </form>';
                return $action;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PembagianKelas $model)
    {
        return $model->newQuery()->where('wali_kelas', $this->id);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('kelas-table')
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
            Column::make('nama_kelas')->title("Nama Kelas"),
            Column::make('action')->title('Action')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Guru/PerwalianKelas/Kelas_' . date('YmdHis');
    }
}
