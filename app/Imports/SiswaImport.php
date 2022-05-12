<?php

namespace App\Imports;

use App\Models\Jurusan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithValidation;

class SiswaImport implements 
    ToCollection, 
    WithHeadingRow, 
    SkipsOnError, 
    WithMultipleSheets,
    WithValidation
{
    use Importable, SkipsErrors;

    public function __construct()
    {
        $this->jurusan = Jurusan::all();
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row ) {
            $user = User::create([
                    'username' => $row['nisn'],
                    'password' => Hash::make($row['nisn']),
                    'role'     => 'siswa'
                ]);

            $jurusan = $this->jurusan->where('jurusan', $row['jurusan'])->first();

            $row['tanggal_lahir'] = Carbon::createFromFormat('d-m-Y', $row['tanggal_lahir'])->format('Y-m-d');
            
            $user->Siswa()->create([
                'name'              => $row['nama'],
                'jenis_kelamin'     => $row['jenis_kelamin'],
                'no_telepon'        => $row['no_telepon'],
                'nisn'              => $row['nisn'],
                'nik'               => $row['nik'],
                'tempat_lahir'      => $row['tempat_lahir'],
                'tanggal_lahir'     => $row['tanggal_lahir'],
                'agama'             => $row['agama'],
                'alamat_lengkap'    => $row['alamat_lengkap'],
                'alamat_rw'         => $row['alamat_rw'],
                'alamat_rt'         => $row['alamat_rt'],
                'alamat_kelurahan'  => $row['alamat_kelurahan'],
                'alamat_kecamatan'  => $row['alamat_kecamatan'],
                'tinggal_bersama'   => $row['tinggal_bersama'],
                'transportasi'      => $row['transportasi'],
                'kode_pos'          => $row['kode_pos'],
                'id_jurusan'        => $jurusan->id,
            ]);
        }
    }

    public function rules(): array
    {
        $getRuleJurusan = array();
        foreach ($this->jurusan as $jurusans) {
            $getRuleJurusan[] = '' . $jurusans->jurusan . '';
        }

        return [
            '*.nama'                => ['required', 'max:255', 'string'],
            '*.jenis_kelamin'       => ['required', Rule::in('laki-laki', 'perempuan')],
            '*.no_telepon'          => ['required', 'max:255', 'string'],
            '*.nisn'                => ['required', 'max:255', 'unique:App\Models\Siswa,nisn'],
            '*.nik'                 => ['required', 'max:255', 'string'],
            '*.tempat_lahir'        => ['required', 'max:255', 'string'],
            '*.tanggal_lahir'       => ['required', 'date', 'date_format:d-m-Y'],
            '*.agama'               => ['required', 'max:255', 'string'],
            '*.alamat_lengkap'      => ['required', 'max:255', 'string'],
            '*.alamat_rt'           => 'required|max:255|string',
            '*.alamat_rw'           => 'required|max:255|string',
            '*.alamat_kelurahan'    => 'required|max:255|string',
            '*.alamat_kecamatan'    => 'required|max:255|string',
            '*.tinggal_bersama'     => ['required', 'max:255', 'string'],
            '*.transportasi'        => ['required', Rule::in('angkutan umum', 'kendaraan pribadi', 'antar jemput')],
            '*.jurusan'             => ['required', Rule::in($getRuleJurusan)],
        ];
    }
}