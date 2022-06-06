<?php

namespace App\DataTables\Siswa;

use App\Models\JadwalKelas;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class JadwalKelasDataTable extends DataTable
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
            ->addColumn('action', 'jadwalkelasdatatable.action')
            ->addColumn('id_pembagian_kelas', function ($data) {
                $pembagianKelas = $data->pembagiankelas;
                return "Kelas " . $pembagianKelas->kelas->kelas . " " . $pembagianKelas->kelas->jurusan->jurusan . " " . $pembagianKelas->nama_kelas;
            })
            ->addColumn('id_matapelajaran', function ($data) {
                return $data->matapelajaran->nama_mapel;
            })
            ->addColumn('id_pengajar', function ($data) {
                return $data->guru->nama;
            })
            ->addColumn('id_jadwal', function ($data) {
                $weekdays = Carbon::getDays();
                return Carbon::create($weekdays[$data->jadwal->hari])->dayName. " Jam " . Carbon::parse($data->jadwal->jam_mulai)->translatedFormat('H:i') . " - " . Carbon::parse($data->jadwal->jam_selesai)->translatedFormat('H:i');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(JadwalKelas $model)
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
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Siswa/JadwalKelas_' . date('YmdHis');
    }
}
