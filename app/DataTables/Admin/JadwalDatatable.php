<?php

namespace App\DataTables\Admin;

use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class JadwalDatatable extends DataTable
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
            ->addColumn('action', function ($data){
                $action =   '<button type="button" class="waves-effect btn btn-sm btn-danger" onclick="actionjadwal(\'' . 'hapus' . '\',\'' . Crypt::encrypt($data->id) . '\')">
                                <i class="fas fa-trash" color=white></i>
                            </button>
                            <button type="button" class="waves-effect btn btn-sm btn-primary" onclick="actionjadwal(\'' . 'edit' . '\',\'' . Crypt::encrypt($data->id) . '\')">
                                <i class="fas fa-pen-square" style="color:white !important;"></i>
                            </button>';
                return $action;
            })
            ->addColumn('hari', function ($data) {
                Carbon::setLocale('id_ID');
                $weekdays = Carbon::getDays();
                $hari = Carbon::create($weekdays[$data->hari])->dayName;
                return $hari;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Jadwal $model)
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
                    ->setTableId('jadwaldatatable-table')
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
            'id' => ['title' => 'No', 'orderable' => false, 'searchable' => false, 'render' => function() {
                return 'function(data,type,fullData,meta){return meta.settings._iDisplayStart+meta.row+1;}';
            }],
            Column::make('jam_mulai')->title('Jam Mulai'),
            Column::make('jam_selesai')->title('Jam Selesai'),
            Column::make('hari'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
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
        return 'Admin/Jadwal_' . date('YmdHis');
    }
}
