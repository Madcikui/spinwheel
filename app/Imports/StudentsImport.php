<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function __construct(
        protected int $branchId
    ) {}

    public function model(array $row)
    {
        return new Student([
            'branch_id'    => $this->branchId,
            'nama_pelajar' => $row['nama_pelajar'],
            'ic_pelajar'   => $row['ic_pelajar'] ?? null,
            'nama_ayah'    => $row['nama_ayah'] ?? null,
            'ic_ayah'      => $row['ic_ayah'] ?? null,
            'nama_ibu'     => $row['nama_ibu'] ?? null,
            'ic_ibu'       => $row['ic_ibu'] ?? null,
            'no_telefon'   => $row['no_telefon'] ?? null,
            'kelas'        => $row['kelas'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_pelajar' => 'required|string|max:255',
            'ic_pelajar'   => 'nullable|string|max:20',
            'nama_ayah'    => 'nullable|string|max:255',
            'ic_ayah'      => 'nullable|string|max:20',
            'nama_ibu'     => 'nullable|string|max:255',
            'ic_ibu'       => 'nullable|string|max:20',
            'no_telefon'   => 'nullable|string|max:20',
            'kelas'        => 'nullable|string|max:50',
        ];
    }
}
