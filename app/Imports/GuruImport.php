<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class GuruImport implements
    ToCollection,
    WithHeadingRow, 
    SkipsOnError, 
    WithMultipleSheets,
    WithValidation
{
    use Importable, SkipsErrors;
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
                    'username' => $row['nip'],
                    'password' => Hash::make($row['nip']),
                    'role'     => 'guru'
                ]);
            
            $user->Guru()->create([
                'nip'                   => $row['nip'],
                'golongan'              => $row['golongan'],
                'nama'                  => $row['nama'],
                'jenis_kelamin'         => $row['jenis_kelamin'],
                'alamat'                => $row['alamat'],
                'no_telepon'            => $row['no_telepon'],
                'pendidikan_terakhir'   => $row['pendidikan_terakhir'],
                'jurusan_pendidikan'    => $row['jurusan_pendidikan'],
            ]);
        }
    }

    public function rules(): array
    {
        return [
            '*.nip'                 => ['required', 'max:255', 'unique:gurus,nip'],
            '*.golongan'            => ['required', 'max:255', 'string'],
            '*.nama'                => ['required', 'max:255', 'string'],
            '*.jenis_kelamin'       => ['required', Rule::in('laki-laki', 'perempuan')],
            '*.alamat'              => ['required', 'max:255', 'string'],
            '*.no_telepon'          => ['required', 'max:255', 'string'],
            '*.pendidikan_terakhir' => ['required', 'max:255', 'string'],
            '*.jurusan_pendidikan'  => ['required', 'max:255', 'string'],
        ];
    }
}