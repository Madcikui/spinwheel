<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Prize;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    public function run(): void
    {
        // === 4 CAWANGAN ===
        $branches = [
            ['nama_cawangan' => 'Tadika Fitrah Ehsan (HQ)', 'slug' => 'tfe-hq'],
            ['nama_cawangan' => 'Tadika Fitrah Ehsan Cawangan Ampang', 'slug' => 'tfe-ampang'],
            ['nama_cawangan' => 'Tadika Fitrah Ehsan Cawangan Setapak', 'slug' => 'tfe-setapak'],
            ['nama_cawangan' => 'Tadika Fitrah Ehsan Cawangan Gombak', 'slug' => 'tfe-gombak'],
        ];

        $branchIds = [];
        foreach ($branches as $b) {
            $branch = Branch::updateOrCreate(['slug' => $b['slug']], $b);
            $branchIds[] = $branch->id;
        }

        // === 15 JENIS HADIAH (shared, total 100 unit) ===
        $prizes = [
            ['nama_hadiah' => 'Basikal',            'kuantiti' => 2,  'warna' => '#ec4899'],
            ['nama_hadiah' => 'Scooter',             'kuantiti' => 3,  'warna' => '#f43f5e'],
            ['nama_hadiah' => 'Tablet Belajar',      'kuantiti' => 3,  'warna' => '#8b5cf6'],
            ['nama_hadiah' => 'Set Alat Tulis',      'kuantiti' => 10, 'warna' => '#3b82f6'],
            ['nama_hadiah' => 'Beg Sekolah',         'kuantiti' => 8,  'warna' => '#06b6d4'],
            ['nama_hadiah' => 'Botol Air',           'kuantiti' => 10, 'warna' => '#10b981'],
            ['nama_hadiah' => 'Kotak Pensil',        'kuantiti' => 10, 'warna' => '#22c55e'],
            ['nama_hadiah' => 'Buku Mewarna',        'kuantiti' => 10, 'warna' => '#eab308'],
            ['nama_hadiah' => 'Set Crayon',          'kuantiti' => 8,  'warna' => '#f59e0b'],
            ['nama_hadiah' => 'Anak Patung',         'kuantiti' => 6,  'warna' => '#f97316'],
            ['nama_hadiah' => 'Puzzle',              'kuantiti' => 8,  'warna' => '#ef4444'],
            ['nama_hadiah' => 'Lego Mini',           'kuantiti' => 6,  'warna' => '#d946ef'],
            ['nama_hadiah' => 'Bekas Makanan',       'kuantiti' => 8,  'warna' => '#a855f7'],
            ['nama_hadiah' => 'Tuala Kecil',         'kuantiti' => 4,  'warna' => '#6366f1'],
            ['nama_hadiah' => 'Jam Tangan Kanak',    'kuantiti' => 4,  'warna' => '#0ea5e9'],
        ];

        foreach ($prizes as $p) {
            Prize::updateOrCreate(
                ['nama_hadiah' => $p['nama_hadiah']],
                array_merge($p, [
                    'kuantiti_baki' => $p['kuantiti'],
                    'branch_id' => null,
                    'aktif' => true,
                ])
            );
        }

        // === 100 STUDENTS (25 per cawangan) ===
        $namaLelaki = [
            'Ahmad', 'Muhammad', 'Aiman', 'Irfan', 'Danial', 'Haziq', 'Aqil',
            'Arif', 'Zafran', 'Hakeem', 'Luqman', 'Rayyan', 'Imran', 'Faiz',
            'Syahmi', 'Nabil', 'Hafiz', 'Adam', 'Izzat', 'Harraz',
        ];

        $namaPerempuan = [
            'Nur', 'Aisyah', 'Fatimah', 'Insyirah', 'Balqis', 'Hana', 'Mariam',
            'Zahra', 'Safiya', 'Aliya', 'Irdina', 'Dahlia', 'Puteri', 'Amani',
            'Wardina', 'Sofea', 'Aqilah', 'Husna', 'Nabila', 'Ilyana',
        ];

        $namaAkhir = [
            'bin Ahmad', 'bin Ismail', 'bin Hassan', 'bin Ali', 'bin Omar',
            'bin Ibrahim', 'bin Yusuf', 'bin Razak', 'bin Kamal', 'bin Zainal',
            'binti Ahmad', 'binti Ismail', 'binti Hassan', 'binti Ali', 'binti Omar',
            'binti Ibrahim', 'binti Yusuf', 'binti Razak', 'binti Kamal', 'binti Zainal',
        ];

        $namaParent = [
            'Mohd Hafizi', 'Mohd Syafiq', 'Mohd Faizal', 'Ahmad Rizal', 'Mohd Azman',
            'Siti Rohana', 'Siti Aminah', 'Nur Hidayah', 'Faridah', 'Rosmah',
            'Mohd Amin', 'Mohd Aziz', 'Mohd Faris', 'Mohd Nizam', 'Mohd Zaki',
            'Siti Zubaidah', 'Nor Aini', 'Suraya', 'Norliza', 'Ramlah',
            'Mohd Shukri', 'Mohd Hanif', 'Mohd Rizwan', 'Ahmad Fitri', 'Mohd Taufik',
        ];

        $kelas = ['4 Bestari', '4 Cemerlang', '5 Bestari', '5 Cemerlang', '6 Bestari', '6 Cemerlang'];

        $studentCount = 0;

        foreach ($branchIds as $idx => $branchId) {
            for ($i = 0; $i < 25; $i++) {
                $studentCount++;
                $isGirl = $i % 2 === 1;
                $first = $isGirl
                    ? $namaPerempuan[array_rand($namaPerempuan)]
                    : $namaLelaki[array_rand($namaLelaki)];
                $last = $namaAkhir[array_rand($namaAkhir)];
                $parent = $namaParent[array_rand($namaParent)];

                // Generate realistic IC (YYMMDD + random)
                $year = str_pad(rand(15, 20), 2, '0', STR_PAD_LEFT);
                $month = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
                $day = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
                $icStudent = $year . $month . $day . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);

                $ayahYear = str_pad(rand(80, 95), 2, '0', STR_PAD_LEFT);
                $icAyah = $ayahYear . $month . $day . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);

                $ibuYear = str_pad(rand(82, 96), 2, '0', STR_PAD_LEFT);
                $icIbu = $ibuYear . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . $day . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);

                $namaAyahList = ['Mohd Hafizi', 'Mohd Syafiq', 'Mohd Faizal', 'Ahmad Rizal', 'Mohd Azman', 'Mohd Amin', 'Mohd Aziz', 'Mohd Faris', 'Mohd Nizam', 'Mohd Zaki', 'Mohd Shukri', 'Mohd Hanif'];
                $namaIbuList = ['Siti Rohana', 'Siti Aminah', 'Nur Hidayah', 'Faridah', 'Rosmah', 'Siti Zubaidah', 'Nor Aini', 'Suraya', 'Norliza', 'Ramlah', 'Nurulain', 'Nor Azizah'];

                $phone = '01' . rand(0, 9) . str_pad(rand(1000000, 9999999), 7, '0', STR_PAD_LEFT);

                Student::create([
                    'branch_id' => $branchId,
                    'nama_pelajar' => $first . ' ' . $last,
                    'ic_pelajar' => $icStudent,
                    'nama_ayah' => $namaAyahList[array_rand($namaAyahList)],
                    'ic_ayah' => $icAyah,
                    'nama_ibu' => $namaIbuList[array_rand($namaIbuList)],
                    'ic_ibu' => $icIbu,
                    'no_telefon' => $phone,
                    'kelas' => $kelas[array_rand($kelas)],
                ]);
            }
        }

        $this->command->info("Selesai! {$studentCount} pelajar, " . count($prizes) . " jenis hadiah, " . count($branches) . " cawangan.");
    }
}
