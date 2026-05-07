<?php

namespace App\Livewire;

use App\Models\BonusCode;
use App\Models\Branch;
use App\Models\Prize;
use App\Models\Setting;
use App\Models\SpinLog;
use App\Models\SpinSound;
use App\Models\Student;
use App\Models\WinSound;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SpinPage extends Component
{
    public ?int $branchId = null;
    public ?string $branchName = null;
    public string $eventName = '';
    public string $instructionText = '';
    public string $ic = '';
    public string $bonusCode = '';
    public string $bonusName = '';
    public ?int $bonusCodeId = null;
    public string $mode = ''; // '' = normal IC spin, 'bonus' = bonus code spin
    public array $matchedStudents = [];
    public ?int $selectedStudentId = null;
    public ?string $studentName = null;
    public array $prizes = [];
    public ?string $winner = null;
    public ?string $winnerImage = null;
    public ?int $winnerPrizeIndex = null;
    public string $step = 'home';
    public string $errorMessage = '';
    public string $gatePassword = '';
    public ?int $studentUmurId = null;

    public function mount(): void
    {
        // Cookie sekarang dilindungi EncryptCookies middleware — nilai yang diforge
        // tak akan decrypt, jadi request->cookie() akan return null.
        if (request()->cookie('spin_auth') !== 'true') {
            $this->step = 'gate';
        }

        $this->eventName = Setting::get('event_name', 'Hari Anugerah & Cabutan Bertuah');
        $this->instructionText = Setting::get('instruction_text', 'Sila ke kaunter hadiah untuk menuntut hadiah anda');
    }

    // === GATE PASSWORD ===

    public function verifyGate()
    {
        $this->errorMessage = '';

        $correctPassword = Setting::get('spin_password', 'TFE2026');

        if (trim($this->gatePassword) === '') {
            $this->errorMessage = 'Sila masukkan password.';
            return;
        }

        if ($this->gatePassword !== $correctPassword) {
            $this->errorMessage = 'Password tidak sah.';
            return;
        }

        // Simpan cookie — expire 0 = session cookie (hilang bila tutup browser)
        cookie()->queue(cookie('spin_auth', 'true', 0, '/', null, false, true));
        $this->step = 'home';
    }

    // === HOMEPAGE ===

    public function pilihCabutan()
    {
        $this->mode = '';
        $this->step = 'ic';
    }

    public function pilihClaim()
    {
        $this->mode = 'bonus';
        $this->step = 'code';
    }

    // === NORMAL SPIN FLOW (IC) ===

    public function cariIC()
    {
        $this->errorMessage = '';
        $this->matchedStudents = [];
        $this->branchId = null;
        $this->branchName = null;

        $ic = preg_replace('/[^0-9]/', '', trim($this->ic));

        if (empty($ic)) {
            $this->errorMessage = 'Sila masukkan nombor IC.';
            return;
        }

        if (strlen($ic) < 3 || strlen($ic) > 14) {
            $this->errorMessage = 'Format IC tidak sah.';
            return;
        }

        $students = Student::with('branch')
            ->where(function ($q) use ($ic) {
                $q->where('ic_ayah', $ic)
                  ->orWhere('ic_ibu', $ic)
                  ->orWhere('ic_pelajar', $ic);
            })
            ->get();

        if ($students->isEmpty()) {
            $this->errorMessage = 'IC tidak dijumpai dalam sistem. Sila semak semula.';
            return;
        }

        $firstStudent = $students->first();
        $this->branchId = $firstStudent->branch_id;
        $this->branchName = $firstStudent->branch->nama_cawangan;

        $this->matchedStudents = $students->map(fn ($s) => [
            'id' => $s->id,
            'nama' => $s->nama_pelajar,
            'kelas' => $s->kelas,
            'cawangan' => $s->branch->nama_cawangan,
            'has_spin' => $s->hasSpin(),
        ])->toArray();

        $available = collect($this->matchedStudents)->where('has_spin', false);

        if ($available->count() === 1) {
            $this->selectedStudentId = $available->first()['id'];
            $this->studentName = $available->first()['nama'];
            $this->branchId = Student::find($this->selectedStudentId)->branch_id;
            $this->branchName = $available->first()['cawangan'];
        }

        $this->step = 'confirm';
    }

    public function pilihAnak(int $studentId)
    {
        // Security: verify student actually belongs to the IC that was searched
        $ic = preg_replace('/[^0-9]/', '', trim($this->ic));
        $studentModel = Student::with('branch')->find($studentId);

        if (!$studentModel) {
            $this->errorMessage = 'Pelajar tidak dijumpai.';
            return;
        }

        if (empty($ic) || !in_array($ic, [$studentModel->ic_ayah, $studentModel->ic_ibu, $studentModel->ic_pelajar])) {
            $this->errorMessage = 'Akses tidak sah.';
            return;
        }

        if ($studentModel->hasSpin()) {
            $this->errorMessage = $studentModel->nama_pelajar . ' sudah membuat cabutan.';
            return;
        }

        $this->selectedStudentId = $studentId;
        $this->studentName = $studentModel->nama_pelajar;
        $this->branchId = $studentModel->branch_id;
        $this->branchName = $studentModel->branch->nama_cawangan;
    }

    public function teruskanSpin()
    {
        $this->errorMessage = '';

        if (!$this->selectedStudentId) {
            $this->errorMessage = 'Sila pilih anak anda.';
            return;
        }

        $student = Student::find($this->selectedStudentId);
        if (!$student || $student->hasSpin()) {
            $this->errorMessage = 'Pelajar ini sudah membuat cabutan.';
            return;
        }

        $this->studentUmurId = $student->umur_id;

        $this->loadPrizes();
        if (empty($this->prizes)) return;

        $this->step = 'spin';
    }

    // === BONUS CODE FLOW ===

    public function verifyCode()
    {
        $this->errorMessage = '';

        $code = strtoupper(trim($this->bonusCode));

        if (empty($code)) {
            $this->errorMessage = 'Sila masukkan code.';
            return;
        }

        $bonusCode = BonusCode::where('code', $code)->first();

        if (!$bonusCode) {
            $this->errorMessage = 'Code tidak sah. Sila semak semula.';
            return;
        }

        if ($bonusCode->status === 'used') {
            $this->errorMessage = 'Code ini sudah digunakan.';
            return;
        }

        $this->bonusCodeId = $bonusCode->id;
        $this->step = 'code_name';
    }

    public function teruskanBonusSpin()
    {
        $this->errorMessage = '';

        $name = trim($this->bonusName);
        if (empty($name)) {
            $this->errorMessage = 'Sila masukkan nama anda.';
            return;
        }

        $this->studentName = $name;

        $this->loadPrizes();
        if (empty($this->prizes)) return;

        $this->step = 'spin';
    }

    // === SHARED SPIN LOGIC ===

    private function loadPrizes(): void
    {
        $query = Prize::where('aktif', true)
            ->where('kuantiti_baki', '>', 0);

        // Bonus code mode: hadiah yang ditandakan tak boleh untuk bonus disembunyi.
        if ($this->mode === 'bonus') {
            $query->where('boleh_bonus', true);
        }

        $this->prizes = $query
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'nama' => $p->nama_hadiah,
                'warna' => $p->warna,
            ])
            ->toArray();

        if (empty($this->prizes)) {
            $this->errorMessage = 'Maaf, semua hadiah telah habis.';
        }
    }

    public function spin()
    {
        $this->errorMessage = '';

        try {
            DB::transaction(function () {
                // Validate based on mode
                if ($this->mode === 'bonus') {
                    $bonusCode = BonusCode::lockForUpdate()->find($this->bonusCodeId);
                    if (!$bonusCode || $bonusCode->status === 'used') {
                        throw new \Exception('Code ini sudah digunakan.');
                    }
                } else {
                    $student = Student::find($this->selectedStudentId);
                    if (!$student || $student->hasSpin()) {
                        throw new \Exception('Pelajar ini sudah membuat cabutan.');
                    }

                    // Security: verify student belongs to the IC that was searched
                    $ic = preg_replace('/[^0-9]/', '', trim($this->ic));
                    if (empty($ic) || !in_array($ic, [$student->ic_ayah, $student->ic_ibu, $student->ic_pelajar])) {
                        throw new \Exception('Akses tidak sah.');
                    }

                    // Security: derive umur from DB, never trust public property
                    $this->studentUmurId = $student->umur_id;
                }

                // Hadiah dipilih MESTI dari slice yang ditunjuk pada wheel.
                // Ini halang admin tukar prize/baki masa wheel tengah berputar
                // → wheel berhenti slice salah, modal tunjuk hadiah lain.
                $displayedPrizeIds = collect($this->prizes)->pluck('id')->filter()->all();

                if (empty($displayedPrizeIds)) {
                    throw new \Exception('Sila refresh halaman dan cuba semula.');
                }

                $prizesQuery = Prize::whereIn('id', $displayedPrizeIds)
                    ->where('aktif', true)
                    ->where('kuantiti_baki', '>', 0);

                if ($this->mode === 'bonus') {
                    $prizesQuery->where('boleh_bonus', true);
                }

                if ($this->studentUmurId !== null) {
                    $prizesQuery->where(function ($q) {
                        $q->whereNull('umur_id')
                          ->orWhere('umur_id', $this->studentUmurId);
                    });
                }

                $availablePrizes = $prizesQuery->lockForUpdate()->get();

                if ($availablePrizes->isEmpty()) {
                    throw new \Exception('Hadiah pada wheel telah habis. Sila refresh halaman.');
                }

                // Anti-repeat
                $recentPrizeIds = SpinLog::orderByDesc('id')
                    ->limit(3)
                    ->pluck('prize_id')
                    ->toArray();

                $nonRepeat = $availablePrizes->whereNotIn('id', $recentPrizeIds);
                $pool = $nonRepeat->isNotEmpty() ? $nonRepeat : $availablePrizes;

                // Weighted random
                $weighted = $pool->flatMap(fn ($p) => array_fill(0, $p->kuantiti_baki, $p));
                $selectedPrize = $weighted->random();

                $selectedPrize->decrement('kuantiti_baki');

                // Create spin log
                $spinLog = SpinLog::create([
                    'student_id' => $this->mode === 'bonus' ? null : $this->selectedStudentId,
                    'prize_id' => $selectedPrize->id,
                    'status' => 'pending',
                    'spun_at' => now(),
                ]);

                // Mark bonus code as used
                if ($this->mode === 'bonus') {
                    $bonusCode->update([
                        'status' => 'used',
                        'used_by_name' => $this->studentName,
                        'spin_log_id' => $spinLog->id,
                        'used_at' => now(),
                    ]);
                }

                $this->winner = $selectedPrize->nama_hadiah;
                $this->winnerImage = $selectedPrize->gambar;

                // Cari index pada wheel — sebab kita constrain whereIn dgn displayedPrizeIds,
                // search ni JANGAN return false. Kalau false, ada bug, batalkan transaksi.
                $this->winnerPrizeIndex = collect($this->prizes)
                    ->search(fn ($p) => $p['id'] === $selectedPrize->id);

                if ($this->winnerPrizeIndex === false) {
                    throw new \Exception('Sila refresh halaman dan cuba semula.');
                }
            });

            $this->dispatch('prize-selected', prizeIndex: $this->winnerPrizeIndex ?? 0);

        } catch (\Illuminate\Database\QueryException $e) {
            // Unique constraint hit (race: pelajar dah ada SpinLog).
            if (str_contains($e->getMessage(), 'spin_logs_student_id_unique') || $e->getCode() === '23000') {
                $this->errorMessage = 'Pelajar ini sudah membuat cabutan.';
            } else {
                $this->errorMessage = 'Ralat sistem. Sila cuba semula.';
            }
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
    }

    public function kembali()
    {
        $this->ic = '';
        $this->bonusCode = '';
        $this->bonusName = '';
        $this->bonusCodeId = null;
        $this->matchedStudents = [];
        $this->selectedStudentId = null;
        $this->studentName = null;
        $this->branchId = null;
        $this->branchName = null;
        $this->errorMessage = '';
        $this->mode = '';
        $this->studentUmurId = null;
        $this->step = 'home';
    }

    public function showResult()
    {
        $this->step = 'result';
    }

    public function render()
    {
        $winSoundUrls = WinSound::where('aktif', true)
            ->pluck('file_path')
            ->map(fn ($path) => asset('storage/' . $path))
            ->values()
            ->toArray();

        $spinSoundUrls = SpinSound::where('aktif', true)
            ->pluck('file_path')
            ->map(fn ($path) => asset('storage/' . $path))
            ->values()
            ->toArray();

        return view('livewire.spin-page')
            ->layout('layouts.spin', [
                'branchName' => $this->branchName ?? 'Cabutan Bertuah',
                'bgmType' => Setting::get('bgm_type', 'stock'),
                'bgmFile' => Setting::get('bgm_file'),
                'winSoundUrls' => $winSoundUrls,
                'spinSoundUrls' => $spinSoundUrls,
            ]);
    }
}
