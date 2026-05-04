<div class="min-h-screen flex items-center justify-center p-4">

    {{-- GATE PASSWORD --}}
    @if($step === 'gate')
    <div class="card-neon rounded-3xl p-8 w-full max-w-sm text-center slide-up relative scanline">
        <div class="text-6xl mb-4" style="filter: drop-shadow(0 0 20px rgba(168,85,247,0.5));">🔐</div>
        <h1 class="text-2xl font-black neon-title mb-2">Masukkan Password</h1>
        <p class="text-sm text-gray-500 mb-6">Untuk akses Cabutan Bertuah</p>

        <div class="mb-5">
            <input
                wire:model="gatePassword"
                wire:keydown.enter="verifyGate"
                type="password"
                placeholder="Password"
                class="input-neon w-full rounded-xl px-4 py-4 text-center text-lg font-semibold tracking-widest"
            />
        </div>

        @if($errorMessage)
            <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-3 mb-4">
                <p class="text-red-400 text-sm font-medium">{{ $errorMessage }}</p>
            </div>
        @endif

        <button
            wire:click="verifyGate"
            wire:loading.attr="disabled"
            onclick="playClickSound()"
            class="btn-neon w-full text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-purple-500/25 transition-all duration-300 hover:-translate-y-0.5 disabled:opacity-50"
        >
            <span wire:loading.remove wire:target="verifyGate">Masuk ➜</span>
            <span wire:loading wire:target="verifyGate">Memeriksa...</span>
        </button>
    </div>
    @endif

    {{-- HOMEPAGE --}}
    @if($step === 'home')
    <div class="card-neon rounded-3xl p-8 w-full max-w-md text-center slide-up relative scanline">
        <div class="text-7xl mb-4" style="filter: drop-shadow(0 0 20px rgba(168,85,247,0.5));">🎡</div>
        <h1 class="text-4xl font-black neon-title mb-2">Cabutan Bertuah</h1>
        <p class="text-sm text-purple-300/80 font-medium mb-10 tracking-widest uppercase">Tadika Fitrah Ehsan</p>

        <div class="grid grid-cols-2 gap-4">
            <button
                wire:click="pilihCabutan"
                onclick="playClickSound()"
                class="group p-6 rounded-2xl border border-white/10 hover:border-purple-500/50 bg-white/5 hover:bg-purple-500/10 transition-all duration-300"
            >
                <div class="text-5xl mb-3 group-hover:scale-110 transition-transform">🎡</div>
                <div class="text-white font-bold text-sm">Cabutan Bertuah</div>
                <div class="text-gray-500 text-xs mt-1">Guna No. IC</div>
            </button>

            <button
                wire:click="pilihClaim"
                onclick="playClickSound()"
                class="group p-6 rounded-2xl border border-white/10 hover:border-amber-500/50 bg-white/5 hover:bg-amber-500/10 transition-all duration-300"
            >
                <div class="text-5xl mb-3 group-hover:scale-110 transition-transform">🎁</div>
                <div class="text-white font-bold text-sm">Claim Hadiah</div>
                <div class="text-gray-500 text-xs mt-1">Guna Code</div>
            </button>
        </div>
    </div>
    @endif

    {{-- STEP: MASUK IC --}}
    @if($step === 'ic')
    <div class="card-neon rounded-3xl p-8 w-full max-w-md text-center slide-up relative scanline">
        <div class="text-7xl mb-4 animate-bounce" style="filter: drop-shadow(0 0 20px rgba(168,85,247,0.5));">🎡</div>
        <h1 class="text-4xl font-black neon-title mb-2">Cabutan Bertuah</h1>
        <p class="text-sm text-purple-300/80 font-medium mb-8 tracking-widest uppercase">Tadika Fitrah Ehsan</p>

        <div class="mb-6">
            <p class="text-gray-400 text-sm mb-3">Masukkan nombor IC untuk meneruskan</p>
            <input
                wire:model="ic"
                wire:keydown.enter="cariIC"
                type="text"
                inputmode="numeric"
                placeholder="Contoh: 901231041234"
                class="input-neon w-full rounded-xl px-4 py-4 text-center text-lg font-semibold tracking-widest"
            />
        </div>

        @if($errorMessage)
            <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-3 mb-4">
                <p class="text-red-400 text-sm font-medium">{{ $errorMessage }}</p>
            </div>
        @endif

        <div class="flex gap-3">
            <button
                wire:click="kembali"
                onclick="playClickSound()"
                class="border border-white/20 text-gray-300 font-bold py-4 px-5 rounded-xl hover:bg-white/5 transition"
            >
                ←
            </button>
            <button
                wire:click="cariIC"
                wire:loading.attr="disabled"
                onclick="playClickSound()"
                class="btn-neon flex-1 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-purple-500/25 hover:shadow-xl hover:shadow-purple-500/40 transition-all duration-300 hover:-translate-y-0.5 disabled:opacity-50"
            >
                <span wire:loading.remove wire:target="cariIC">Teruskan ➜</span>
                <span wire:loading wire:target="cariIC">
                    <svg class="animate-spin inline w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    Mencari...
                </span>
            </button>
        </div>
    </div>
    @endif

    {{-- STEP 2: SAHKAN NAMA ANAK --}}
    @if($step === 'confirm')
    <div class="card-neon rounded-3xl p-8 w-full max-w-md text-center slide-up relative scanline">
        <div class="text-5xl mb-3">👨‍👩‍👧‍👦</div>
        <h2 class="text-xl font-bold text-purple-300 mb-1">Sahkan Anak Anda</h2>
        <p class="text-gray-500 text-sm mb-5">Pilih nama anak yang ingin membuat cabutan</p>

        <div class="space-y-3 mb-6">
            @foreach($matchedStudents as $student)
                <button
                    wire:click="pilihAnak({{ $student['id'] }})"
                    onclick="playClickSound()"
                    @class([
                        'w-full p-4 rounded-xl border text-left transition-all duration-300',
                        'border-purple-500 bg-purple-500/15 shadow-lg shadow-purple-500/10 scale-[1.02]' => $selectedStudentId === $student['id'],
                        'border-white/10 hover:border-purple-400/50 hover:bg-white/5' => $selectedStudentId !== $student['id'],
                        'opacity-30 cursor-not-allowed' => $student['has_spin'],
                    ])
                    @disabled($student['has_spin'])
                >
                    <div class="text-center">
                        <div class="font-bold text-white">{{ $student['nama'] }}</div>
                        <div class="text-sm text-gray-400">{{ $student['cawangan'] }} &middot; {{ $student['kelas'] ?? '-' }}</div>
                        @if($student['has_spin'])
                            <span class="inline-block mt-2 text-xs bg-green-500/20 text-green-400 font-semibold px-3 py-1 rounded-full border border-green-500/30">Sudah Spin</span>
                        @elseif($selectedStudentId === $student['id'])
                            <span class="inline-block mt-1 text-purple-400 text-xl">✓</span>
                        @endif
                    </div>
                </button>
            @endforeach
        </div>

        @if($errorMessage)
            <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-3 mb-3">
                <p class="text-red-400 text-sm font-medium">{{ $errorMessage }}</p>
            </div>
        @endif

        <div class="flex gap-3">
            <button
                wire:click="kembali"
                onclick="playClickSound()"
                class="flex-1 border border-white/20 text-gray-300 font-bold py-3 px-6 rounded-xl hover:bg-white/5 transition"
            >
                ← Kembali
            </button>
            <button
                wire:click="teruskanSpin"
                wire:loading.attr="disabled"
                onclick="playClickSound()"
                @disabled(!$selectedStudentId)
                class="btn-neon flex-1 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-purple-500/25 transition-all duration-300 disabled:opacity-50 disabled:shadow-none"
            >
                <span wire:loading.remove wire:target="teruskanSpin">Teruskan ➜</span>
                <span wire:loading wire:target="teruskanSpin">Loading...</span>
            </button>
        </div>
    </div>
    @endif

    {{-- BONUS: MASUK CODE --}}
    @if($step === 'code')
    <div class="card-neon rounded-3xl p-8 w-full max-w-md text-center slide-up relative scanline">
        <div class="text-6xl mb-4" style="filter: drop-shadow(0 0 20px rgba(251,191,36,0.5));">🎫</div>
        <h2 class="text-2xl font-bold text-amber-300 mb-2">Claim Hadiah</h2>
        <p class="text-gray-400 text-sm mb-6">Masukkan unique code anda</p>

        <div class="mb-6">
            <input
                wire:model="bonusCode"
                wire:keydown.enter="verifyCode"
                type="text"
                placeholder="Contoh: TFE-X7K9M2"
                class="input-neon w-full rounded-xl px-4 py-4 text-center text-lg font-bold tracking-[0.3em] uppercase"
            />
        </div>

        @if($errorMessage)
            <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-3 mb-4">
                <p class="text-red-400 text-sm font-medium">{{ $errorMessage }}</p>
            </div>
        @endif

        <div class="flex gap-3">
            <button
                wire:click="kembali"
                onclick="playClickSound()"
                class="flex-1 border border-white/20 text-gray-300 font-bold py-3 px-6 rounded-xl hover:bg-white/5 transition"
            >
                ← Kembali
            </button>
            <button
                wire:click="verifyCode"
                wire:loading.attr="disabled"
                onclick="playClickSound()"
                class="btn-neon flex-1 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-purple-500/25 transition-all duration-300 disabled:opacity-50"
            >
                <span wire:loading.remove wire:target="verifyCode">Sahkan ➜</span>
                <span wire:loading wire:target="verifyCode">Memeriksa...</span>
            </button>
        </div>
    </div>
    @endif

    {{-- BONUS: MASUK NAMA --}}
    @if($step === 'code_name')
    <div class="card-neon rounded-3xl p-8 w-full max-w-md text-center slide-up relative scanline">
        <div class="text-5xl mb-3">👋</div>
        <h2 class="text-xl font-bold text-purple-300 mb-2">Siapa Nama Anda?</h2>
        <p class="text-gray-500 text-sm mb-6">Masukkan nama untuk rekod cabutan</p>

        <div class="mb-6">
            <input
                wire:model="bonusName"
                wire:keydown.enter="teruskanBonusSpin"
                type="text"
                placeholder="Nama penuh"
                class="input-neon w-full rounded-xl px-4 py-4 text-center text-lg font-semibold"
            />
        </div>

        @if($errorMessage)
            <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-3 mb-4">
                <p class="text-red-400 text-sm font-medium">{{ $errorMessage }}</p>
            </div>
        @endif

        <div class="flex gap-3">
            <button
                wire:click="$set('step', 'code')"
                onclick="playClickSound()"
                class="flex-1 border border-white/20 text-gray-300 font-bold py-3 px-6 rounded-xl hover:bg-white/5 transition"
            >
                ← Kembali
            </button>
            <button
                wire:click="teruskanBonusSpin"
                wire:loading.attr="disabled"
                onclick="playClickSound()"
                class="btn-neon flex-1 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-purple-500/25 transition-all duration-300 disabled:opacity-50"
            >
                <span wire:loading.remove wire:target="teruskanBonusSpin">Spin Sekarang! 🎡</span>
                <span wire:loading wire:target="teruskanBonusSpin">Loading...</span>
            </button>
        </div>
    </div>
    @endif

    {{-- SPIN WHEEL --}}
    @if($step === 'spin')
    <div
        x-data="spinWheel(@js($prizes))"
        x-init="init()"
        @prize-selected.window="spinTo($event.detail.prizeIndex)"
        class="flex flex-col items-center gap-5 w-full max-w-3xl slide-up"
    >
        <div class="text-center mb-2">
            <h2 class="text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                {{ $studentName }} <span class="neon-title">🎊</span>
            </h2>
            <p class="text-purple-300/70 mt-2 text-base lg:text-lg">Tekan butang untuk putar roda!</p>
        </div>

        {{-- Wheel Container with stand — responsive --}}
        <div class="flex flex-col items-center" x-ref="wheelWrap">
            <div class="relative mx-auto" :style="'width:' + wheelSize + 'px; height:' + wheelSize + 'px'">
                {{-- Outer golden glow --}}
                <div class="absolute rounded-full opacity-40 blur-2xl"
                     style="inset: -16px; background: radial-gradient(circle, rgba(218,165,32,0.6), rgba(139,69,19,0.3), transparent);"></div>

                {{-- Canvas draws everything: rim, bulbs, segments, center --}}
                <canvas id="wheel" class="relative z-10"></canvas>

                {{-- Gold pointer at TOP --}}
                <div :style="'position:absolute; top:' + (-wheelSize * 0.053) + 'px; left:50%; transform:translateX(-50%); z-index:20; filter:drop-shadow(0 4px 8px rgba(0,0,0,0.5))'">
                    <svg :width="wheelSize * 0.1" :height="wheelSize * 0.13" viewBox="0 0 36 44">
                        <defs>
                            <linearGradient id="pointerGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" style="stop-color:#ffd700"/>
                                <stop offset="50%" style="stop-color:#daa520"/>
                                <stop offset="100%" style="stop-color:#b8860b"/>
                            </linearGradient>
                        </defs>
                        <path d="M18 0 C24 0 30 4 30 12 L18 42 L6 12 C6 4 12 0 18 0Z" fill="url(#pointerGrad)" stroke="#8B6914" stroke-width="1.5"/>
                        <circle cx="18" cy="14" r="6" fill="#FFD700" stroke="#B8860B" stroke-width="1"/>
                        <circle cx="18" cy="14" r="3.5" fill="#FFF8DC" opacity="0.8"/>
                    </svg>
                </div>
            </div>

            {{-- Stand / Pedestal — scales with wheel --}}
            <div class="relative z-10" style="margin-top: -4px;">
                <svg :width="wheelSize * 0.35" :height="wheelSize * 0.15" viewBox="0 0 120 50">
                    <defs>
                        <linearGradient id="standGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#2d2d2d"/>
                            <stop offset="100%" style="stop-color:#111111"/>
                        </linearGradient>
                    </defs>
                    <rect x="50" y="0" width="20" height="20" rx="2" fill="url(#standGrad)" stroke="#444" stroke-width="0.5"/>
                    <path d="M15 20 L105 20 L115 45 Q115 50 110 50 L10 50 Q5 50 5 45 Z" fill="url(#standGrad)" stroke="#444" stroke-width="0.5"/>
                    <path d="M20 25 L100 25 L108 45 L12 45 Z" fill="rgba(255,255,255,0.03)"/>
                </svg>
            </div>
        </div>

        @if($errorMessage)
            <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-3">
                <p class="text-red-400 text-sm font-medium">{{ $errorMessage }}</p>
            </div>
        @endif

        <button
            @click="startSpin()"
            :disabled="spinning"
            class="btn-spin btn-neon text-white font-extrabold text-xl py-4 px-14 rounded-full shadow-xl shadow-purple-500/30 hover:shadow-2xl hover:shadow-purple-500/50 active:scale-95 transition-all duration-300 disabled:opacity-50 disabled:animate-none"
        >
            <span x-show="!spinning">🎡 PUTAR!</span>
            <span x-show="spinning" x-cloak class="flex items-center gap-2">
                <svg class="animate-spin w-6 h-6" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                Berpusing...
            </span>
        </button>
    </div>
    @endif

    {{-- STEP 4: RESULT --}}
    @if($step === 'result')
    <div
        x-data
        x-init="
            fireConfetti();
            setTimeout(() => fireConfetti(), 1500);
            setTimeout(() => fireConfetti(), 2500);
        "
        class="card-neon rounded-3xl p-10 text-center w-full max-w-md slide-up relative overflow-hidden"
    >
        {{-- Animated background sparkles --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-4 left-6 text-2xl animate-ping" style="animation-duration: 2s;">✨</div>
            <div class="absolute top-8 right-8 text-xl animate-ping" style="animation-duration: 2.5s; animation-delay: 0.5s;">🌟</div>
            <div class="absolute bottom-12 left-10 text-xl animate-ping" style="animation-duration: 3s; animation-delay: 1s;">⭐</div>
            <div class="absolute bottom-8 right-6 text-2xl animate-ping" style="animation-duration: 2.2s; animation-delay: 0.3s;">💫</div>
        </div>

        <div class="relative z-10">
            <div class="text-8xl mb-4 trophy-bounce" style="filter: drop-shadow(0 0 20px rgba(251,191,36,0.5));">🎁</div>
            <h2 class="text-3xl font-extrabold neon-title mb-3">Tahniah!</h2>
            <p class="text-gray-300 text-lg mb-4">{{ $studentName }} telah memenangi:</p>

            <div class="bg-gradient-to-br from-amber-500/10 to-yellow-500/10 border border-yellow-500/40 rounded-2xl py-5 px-6 mb-6" style="box-shadow: inset 0 0 30px rgba(251,191,36,0.05), 0 0 20px rgba(251,191,36,0.1);">
                @if($winnerImage)
                    <img src="{{ asset('storage/' . $winnerImage) }}" alt="{{ $winner }}" class="w-24 h-24 mx-auto mb-3 object-contain" style="filter: drop-shadow(0 0 15px rgba(251,191,36,0.4));" />
                @else
                    <div class="text-4xl mb-2">🏆</div>
                @endif
                <div class="text-2xl font-extrabold shimmer-text">{{ $winner }}</div>
            </div>

            <div class="bg-purple-500/10 border border-purple-500/20 rounded-xl p-4 mb-5">
                <p class="text-purple-300 font-semibold text-sm">📍 {{ $instructionText }}</p>
            </div>

            <div class="border-t border-white/10 pt-4">
                <p class="text-sm font-bold text-white/80">{{ $branchName }}</p>
                <p class="text-xs text-gray-500 mt-0.5">{{ $eventName }}</p>
            </div>
        </div>
    </div>
    @endif

</div>

@push('scripts')
<script>
function spinWheel(prizes) {
    return {
        spinning: false,
        currentAngle: 0,
        canvas: null,
        ctx: null,
        lastTickAngle: 0,
        wheelSize: 340,

        init() {
            this.calcSize();
            this.canvas = document.getElementById('wheel');
            if (!this.canvas) return;
            this.setupCanvas();
            this.drawWheel(this.currentAngle);

            window.addEventListener('resize', () => {
                if (this.spinning) return;
                const oldSize = this.wheelSize;
                this.calcSize();
                if (oldSize !== this.wheelSize) {
                    this.setupCanvas();
                    this.drawWheel(this.currentAngle);
                }
            });
        },

        calcSize() {
            const vw = window.innerWidth;
            const vh = window.innerHeight;
            if (vw >= 1920)      this.wheelSize = 600;
            else if (vw >= 1280) this.wheelSize = 480;
            else if (vw >= 1024) this.wheelSize = 420;
            else if (vw >= 768)  this.wheelSize = 380;
            else                 this.wheelSize = Math.min(vw - 40, 340);

            // Also cap by available height (leave room for header + button)
            const maxByHeight = vh - 240;
            if (this.wheelSize > maxByHeight) this.wheelSize = Math.max(280, maxByHeight);
        },

        setupCanvas() {
            const dpr = window.devicePixelRatio || 1;
            const s = this.wheelSize;
            this.canvas.width = s * dpr;
            this.canvas.height = s * dpr;
            this.canvas.style.width = s + 'px';
            this.canvas.style.height = s + 'px';
            this.ctx = this.canvas.getContext('2d');
            this.ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        },

        drawWheel(rotation) {
            const ctx = this.ctx;
            const S = this.wheelSize;
            const cx = S / 2, cy = S / 2;
            // All radii proportional to wheel size (base 340)
            const scale = S / 340;
            const outerRimRadius = 164 * scale;
            const innerRimRadius = 148 * scale;
            const segmentRadius = 145 * scale;
            const bulbCount = 24;
            const bulbRadius = 5 * scale;
            const sliceAngle = (2 * Math.PI) / prizes.length;

            ctx.clearRect(0, 0, S, S);

            // === 1. OUTER RIM (dark maroon/brown metallic) ===
            const rimGrd = ctx.createRadialGradient(cx, cy, innerRimRadius, cx, cy, outerRimRadius + 4);
            rimGrd.addColorStop(0, '#8B4513');
            rimGrd.addColorStop(0.3, '#5C2E0E');
            rimGrd.addColorStop(0.6, '#3E1A05');
            rimGrd.addColorStop(1, '#1a0a02');
            ctx.beginPath();
            ctx.arc(cx, cy, outerRimRadius + 4, 0, 2 * Math.PI);
            ctx.fillStyle = rimGrd;
            ctx.fill();

            // Rim inner gold edge
            ctx.beginPath();
            ctx.arc(cx, cy, innerRimRadius + 1, 0, 2 * Math.PI);
            ctx.strokeStyle = '#DAA520';
            ctx.lineWidth = 2;
            ctx.stroke();

            // Rim outer gold edge
            ctx.beginPath();
            ctx.arc(cx, cy, outerRimRadius + 4, 0, 2 * Math.PI);
            ctx.strokeStyle = '#B8860B';
            ctx.lineWidth = 2.5;
            ctx.stroke();

            // === 2. LIGHT BULBS around the rim ===
            const bulbRingRadius = (innerRimRadius + outerRimRadius) / 2 + 2;
            for (let i = 0; i < bulbCount; i++) {
                const angle = (2 * Math.PI / bulbCount) * i;
                const bx = cx + bulbRingRadius * Math.cos(angle);
                const by = cy + bulbRingRadius * Math.sin(angle);

                // Bulb glow
                const glowSize = bulbRadius + 4 * scale;
                const glowGrd = ctx.createRadialGradient(bx, by, 0, bx, by, glowSize);
                glowGrd.addColorStop(0, 'rgba(255,215,0,0.6)');
                glowGrd.addColorStop(1, 'rgba(255,215,0,0)');
                ctx.beginPath();
                ctx.arc(bx, by, glowSize, 0, 2 * Math.PI);
                ctx.fillStyle = glowGrd;
                ctx.fill();

                // Bulb body
                const bulbGrd = ctx.createRadialGradient(bx - 1, by - 1, 0, bx, by, bulbRadius);
                bulbGrd.addColorStop(0, '#FFF8DC');
                bulbGrd.addColorStop(0.5, '#FFD700');
                bulbGrd.addColorStop(1, '#DAA520');
                ctx.beginPath();
                ctx.arc(bx, by, bulbRadius, 0, 2 * Math.PI);
                ctx.fillStyle = bulbGrd;
                ctx.fill();
                ctx.strokeStyle = '#B8860B';
                ctx.lineWidth = 0.8;
                ctx.stroke();
            }

            // === 3. SEGMENTS (keep existing colors from DB) ===
            prizes.forEach((prize, i) => {
                const start = rotation + i * sliceAngle;
                const end = start + sliceAngle;

                // Slice fill with gradient
                ctx.beginPath();
                ctx.moveTo(cx, cy);
                ctx.arc(cx, cy, segmentRadius, start, end);
                ctx.closePath();

                const grd = ctx.createRadialGradient(cx, cy, 20 * scale, cx, cy, segmentRadius);
                const baseColor = prize.warna || '#FF6384';
                grd.addColorStop(0, this.lightenColor(baseColor, 30));
                grd.addColorStop(1, baseColor);
                ctx.fillStyle = grd;
                ctx.fill();

                // Slice border
                ctx.strokeStyle = 'rgba(255,255,255,0.7)';
                ctx.lineWidth = 1.5;
                ctx.stroke();

                // Decorative line
                ctx.beginPath();
                ctx.moveTo(cx + 28 * scale * Math.cos(start), cy + 28 * scale * Math.sin(start));
                ctx.lineTo(cx + segmentRadius * Math.cos(start), cy + segmentRadius * Math.sin(start));
                ctx.strokeStyle = 'rgba(255,255,255,0.25)';
                ctx.lineWidth = 1;
                ctx.stroke();

                // Text
                ctx.save();
                ctx.translate(cx, cy);
                ctx.rotate(start + sliceAngle / 2);
                ctx.textAlign = 'right';
                ctx.fillStyle = '#fff';
                const fontSize = Math.round(12 * scale);
                ctx.font = 'bold ' + fontSize + 'px Poppins, sans-serif';
                ctx.shadowColor = 'rgba(0,0,0,0.6)';
                ctx.shadowBlur = 4 * scale;
                ctx.shadowOffsetX = 1;
                ctx.shadowOffsetY = 1;
                const maxChars = S >= 480 ? 16 : 12;
                const text = prize.nama.length > maxChars ? prize.nama.slice(0, maxChars) + '…' : prize.nama;
                ctx.fillText(text, segmentRadius - 14 * scale, 5);
                ctx.restore();
            });

            // Thin dark ring around segments
            ctx.beginPath();
            ctx.arc(cx, cy, segmentRadius, 0, 2 * Math.PI);
            ctx.strokeStyle = 'rgba(0,0,0,0.3)';
            ctx.lineWidth = 2;
            ctx.stroke();

            // === 4. CENTER HUB (gold ring + red gem) ===
            // Outer gold ring
            const hubOuter = 26 * scale;
            const hubInner = 18 * scale;
            const hubGrd = ctx.createRadialGradient(cx, cy, 16 * scale, cx, cy, hubOuter);
            hubGrd.addColorStop(0, '#FFD700');
            hubGrd.addColorStop(0.5, '#DAA520');
            hubGrd.addColorStop(1, '#B8860B');
            ctx.beginPath();
            ctx.arc(cx, cy, hubOuter, 0, 2 * Math.PI);
            ctx.fillStyle = hubGrd;
            ctx.fill();
            ctx.strokeStyle = '#8B6914';
            ctx.lineWidth = 1.5;
            ctx.stroke();

            // Inner dark circle
            const innerGrd = ctx.createRadialGradient(cx, cy, 0, cx, cy, hubInner);
            innerGrd.addColorStop(0, '#4a0000');
            innerGrd.addColorStop(0.6, '#8B0000');
            innerGrd.addColorStop(1, '#5a0000');
            ctx.beginPath();
            ctx.arc(cx, cy, hubInner, 0, 2 * Math.PI);
            ctx.fillStyle = innerGrd;
            ctx.fill();
            ctx.strokeStyle = '#DAA520';
            ctx.lineWidth = 2;
            ctx.stroke();

            // Gem highlight
            ctx.beginPath();
            ctx.arc(cx - 4 * scale, cy - 4 * scale, 6 * scale, 0, 2 * Math.PI);
            ctx.fillStyle = 'rgba(255,255,255,0.15)';
            ctx.fill();

            // Reset shadow
            ctx.shadowColor = 'transparent';
            ctx.shadowBlur = 0;
            ctx.shadowOffsetX = 0;
            ctx.shadowOffsetY = 0;
        },

        lightenColor(hex, percent) {
            const num = parseInt(hex.replace('#', ''), 16);
            const amt = Math.round(2.55 * percent);
            const R = Math.min(255, (num >> 16) + amt);
            const G = Math.min(255, ((num >> 8) & 0x00FF) + amt);
            const B = Math.min(255, (num & 0x0000FF) + amt);
            return '#' + (0x1000000 + R * 0x10000 + G * 0x100 + B).toString(16).slice(1);
        },

        startSpin() {
            if (this.spinning) return;
            this.spinning = true;

            // Unlock audio on user gesture — critical for mobile browsers
            const ctx = getAudioCtx();
            if (ctx.state === 'suspended') ctx.resume();

            // Unlock win-audio pool on user gesture — critical for mobile browsers
            if (typeof winAudioPool !== 'undefined' && winAudioPool.length) {
                winAudioPool.forEach(audio => {
                    audio.load();
                    const originalVol = audio.volume;
                    audio.volume = 0;
                    audio.play().then(() => {
                        audio.pause();
                        audio.currentTime = 0;
                        audio.volume = originalVol;
                    }).catch(() => {});
                });
            }

            playClickSound();
            this.$wire.spin();
        },

        spinTo(index) {
            // Re-acquire canvas in case Livewire re-rendered the DOM
            this.canvas = document.getElementById('wheel');
            if (!this.canvas) return;
            this.setupCanvas();

            const totalSlices = prizes.length;
            const sliceAngle = (2 * Math.PI) / totalSlices;

            // Pointer is at TOP (-PI/2), so offset target accordingly
            const target = (2 * Math.PI) - (index * sliceAngle) - (sliceAngle / 2) - (Math.PI / 2);
            const spins = 6 * 2 * Math.PI;
            const finalAngle = spins + target;

            const duration = 6000;
            const startTime = performance.now();
            const startAngle = this.currentAngle;
            this.lastTickAngle = startAngle;

            const animate = (now) => {
                const elapsed = now - startTime;
                const t = Math.min(elapsed / duration, 1);
                // Smoother ease-out
                const ease = 1 - Math.pow(1 - t, 4);
                this.currentAngle = startAngle + finalAngle * ease;
                this.drawWheel(this.currentAngle);

                // Tick sound when passing slice boundaries
                const angleDiff = Math.abs(this.currentAngle - this.lastTickAngle);
                if (angleDiff >= sliceAngle * 0.8) {
                    playTick();
                    this.lastTickAngle = this.currentAngle;
                }

                if (t < 1) {
                    requestAnimationFrame(animate);
                } else {
                    // Wheel stopped — play celebration BEFORE showing result
                    playWinCelebration();
                    fireConfetti();

                    setTimeout(() => {
                        this.$wire.showResult();
                    }, 1200);
                }
            };

            requestAnimationFrame(animate);
        }
    }
}
</script>
@endpush
