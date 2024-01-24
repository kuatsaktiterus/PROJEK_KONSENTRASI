<?php

namespace App\DataTables\Admin;

use App\Models\JadwalKelas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class JadwalKelasDatatable extends DataTable
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
                $action =   '<button type="button" class="waves-effect btn btn-sm btn-danger" onclick="actionjadwalkelas(\'' . 'hapus' . '\',\'' . Crypt::encrypt($data->id) . '\')">
                                <i class="fas fa-trash" color=white></i>
                            </button>
                            <button type="button" class="waves-effect btn btn-sm btn-primary" onclick="actionjadwalkelas(\'' . 'edit' . '\',\'' . Crypt::encrypt($data->id) . '\')">
                                <i class="fas fa-pen-square" style="color:white;"></i>
                            </button>';
                return $action;
            })
            ->addColumn('id_pembagian_kelas', function ($data) {
                $pembagianKelas = $data->pembagiankelas;
                return "Kelas " . $pembagianKelas->kelas->kelas . " " . $pembagianKelas->kelas->jurusan->jurusan . " " . $pembagianKelas->nama_kelas;
            })
            ->addColumn('id_matapelajaran', function ($data) {
                return $data->matapelajaran->nama_mapel;
            })
            ->addColumn('id_pengajar', function ($data) {
                return $data->guru->nip . ' - ' . $data->guru->nama;
            })
            ->addColumn('id_jadwal', function ($data) {
                $weekdays = Carbon::getDays();
                Carbon::setlocale('id');
                return "Hari " . Carbon::create($weekdays[$data->jadwal->hari])->dayName. " dari pukul " . Carbon::parse($data->jadwal->jam_mulai)->translatedFormat('H:i') . " sampai pukul " . Carbon::parse($data->jadwal->jam_selesai)->translatedFormat('H:i');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(JadwalKelas $model)
    {
        return $model->newQuery()->whereHas('pembagiankelas')->where('id_pembagian_kelas', $this->id);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('jadwalkelasdatatable-table')
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
            Column::make('id_pembagian_kelas')->title('Kelas'),
            Column::make('id_matapelajaran')->title('Mata Pelajaran'),
            Column::make('id_pengajar')->title('Pengajar'),
            Column::make('id_jadwal')->title('Jadwal'),
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
        return 'Admin/JadwalKelas_' . date('YmdHis');
    }
}
