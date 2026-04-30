<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabutan Bertuah — {{ $branchName ?? 'Tadika' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800;900&display=swap');

        body {
            font-family: 'Poppins', system-ui, -apple-system, sans-serif;
        }

        /* Dark vibrant background */
        .bg-animated {
            background: #0f0a1a;
            background-image:
                radial-gradient(ellipse at 20% 50%, rgba(120, 40, 200, 0.25) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(255, 50, 120, 0.2) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 80%, rgba(0, 180, 255, 0.15) 0%, transparent 50%);
            animation: bgPulse 8s ease-in-out infinite;
            overflow: hidden;
        }

        @keyframes bgPulse {
            0%, 100% { background-size: 100% 100%, 100% 100%, 100% 100%; }
            50% { background-size: 120% 120%, 110% 110%, 130% 130%; }
        }

        /* Grid overlay */
        .bg-animated::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
            z-index: 1;
        }

        /* Floating particles */
        .particle {
            position: fixed;
            pointer-events: none;
            animation: floatUp linear infinite;
            z-index: 2;
        }

        @keyframes floatUp {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.8; }
            90% { opacity: 0.8; }
            100% { transform: translateY(-10vh) rotate(720deg); opacity: 0; }
        }

        /* Neon glow card */
        .card-neon {
            background: rgba(15, 10, 30, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow:
                0 0 30px rgba(168, 85, 247, 0.15),
                0 25px 50px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            animation: cardGlow 3s ease-in-out infinite;
        }

        @keyframes cardGlow {
            0%, 100% {
                box-shadow:
                    0 0 30px rgba(168, 85, 247, 0.15),
                    0 25px 50px rgba(0, 0, 0, 0.5),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
            }
            50% {
                box-shadow:
                    0 0 50px rgba(168, 85, 247, 0.3),
                    0 0 100px rgba(236, 72, 153, 0.15),
                    0 25px 50px rgba(0, 0, 0, 0.5),
                    inset 0 1px 0 rgba(255, 255, 255, 0.15);
            }
        }

        /* Neon text */
        .neon-title {
            background: linear-gradient(135deg, #f472b6, #c084fc, #60a5fa, #34d399);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: neonShift 4s ease infinite;
            filter: drop-shadow(0 0 20px rgba(168, 85, 247, 0.5));
        }

        @keyframes neonShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* Neon button */
        .btn-neon {
            background: linear-gradient(135deg, #ec4899, #8b5cf6, #06b6d4);
            background-size: 200% 200%;
            animation: btnNeonShift 3s ease infinite;
            position: relative;
            overflow: hidden;
        }

        .btn-neon::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transform: translateX(-100%);
            animation: btnShine 3s ease-in-out infinite;
        }

        @keyframes btnNeonShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        @keyframes btnShine {
            0% { transform: translateX(-100%); }
            60% { transform: translateX(100%); }
            100% { transform: translateX(100%); }
        }

        /* Input neon focus */
        .input-neon {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s;
        }

        .input-neon::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .input-neon:focus {
            border-color: #a855f7;
            box-shadow: 0 0 20px rgba(168, 85, 247, 0.3), 0 0 40px rgba(168, 85, 247, 0.1);
            background: rgba(255, 255, 255, 0.08);
            outline: none;
        }

        /* Slide up entrance */
        .slide-up {
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Winner text shimmer */
        .shimmer-text {
            background: linear-gradient(90deg, #f59e0b, #fbbf24, #fff, #fbbf24, #f59e0b);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 2s linear infinite;
        }

        @keyframes shimmer {
            to { background-position: 200% center; }
        }

        /* Spin button bounce */
        .btn-spin {
            animation: btnBounce 2s ease-in-out infinite;
        }

        @keyframes btnBounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .btn-spin:hover {
            animation: none;
            transform: scale(1.08);
        }

        /* Trophy bounce */
        .trophy-bounce {
            animation: trophyBounce 1s ease-in-out infinite;
        }

        @keyframes trophyBounce {
            0%, 100% { transform: translateY(0) rotate(-5deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        /* Floating orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(60px);
            pointer-events: none;
            z-index: 0;
            animation: orbFloat 10s ease-in-out infinite;
        }

        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(30px, -30px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(20px, 10px) scale(1.05); }
        }

        /* Scan line effect */
        .scanline::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(transparent 50%, rgba(168, 85, 247, 0.02) 50%);
            background-size: 100% 4px;
            pointer-events: none;
            border-radius: 1.5rem;
        }
    </style>
</head>
<body class="min-h-screen bg-animated relative overflow-x-hidden">
    <!-- Floating orbs -->
    <div class="orb" style="width:300px;height:300px;background:#7c3aed;top:10%;left:-5%;opacity:0.15;"></div>
    <div class="orb" style="width:250px;height:250px;background:#ec4899;bottom:10%;right:-5%;opacity:0.12;animation-delay:-3s;"></div>
    <div class="orb" style="width:200px;height:200px;background:#06b6d4;top:50%;left:50%;opacity:0.1;animation-delay:-6s;"></div>

    <!-- Floating particles -->
    <div id="particles" class="fixed inset-0 pointer-events-none z-2"></div>

    @if(($bgmType ?? 'stock') !== 'off')
    <!-- BGM Toggle Button -->
    <button
        id="bgm-toggle"
        onclick="toggleBGM()"
        title="Hidupkan Muzik"
        style="position:fixed; bottom:20px; right:20px; z-index:50; width:48px; height:48px; border-radius:50%; border:2px solid rgba(168,85,247,0.5); background:rgba(15,10,30,0.8); backdrop-filter:blur(10px); color:white; font-size:22px; cursor:pointer; transition:all 0.3s; box-shadow:0 0 20px rgba(168,85,247,0.2);"
        onmouseover="this.style.borderColor='#a855f7'; this.style.boxShadow='0 0 30px rgba(168,85,247,0.4)';"
        onmouseout="this.style.borderColor='rgba(168,85,247,0.5)'; this.style.boxShadow='0 0 20px rgba(168,85,247,0.2)';"
    >🔇</button>
    @endif

    <div class="relative z-10">
        {{ $slot }}
    </div>

    @livewireScripts

    <script>
    // === FLOATING PARTICLES ===
    function createParticles() {
        const container = document.getElementById('particles');
        const emojis = ['✦', '✧', '◆', '○', '◇', '⬥', '✶', '⬦'];

        for (let i = 0; i < 20; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.textContent = emojis[Math.floor(Math.random() * emojis.length)];
            particle.style.left = Math.random() * 100 + '%';
            particle.style.fontSize = (Math.random() * 16 + 10) + 'px';
            particle.style.animationDuration = (Math.random() * 12 + 10) + 's';
            particle.style.animationDelay = (Math.random() * 10) + 's';
            const colors = ['#a855f7', '#ec4899', '#06b6d4', '#22c55e', '#f59e0b', '#6366f1'];
            particle.style.color = colors[Math.floor(Math.random() * colors.length)];
            particle.style.opacity = '0.4';
            particle.style.textShadow = '0 0 10px currentColor';
            container.appendChild(particle);
        }
    }
    createParticles();

    // === SOUND ENGINE (Web Audio API — no files needed) ===
    const AudioCtx = window.AudioContext || window.webkitAudioContext;
    let audioCtx = null;

    function getAudioCtx() {
        if (!audioCtx) audioCtx = new AudioCtx();
        return audioCtx;
    }

    function playTick() {
        try {
            const ctx = getAudioCtx();
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.type = 'sine';
            osc.frequency.setValueAtTime(800 + Math.random() * 400, ctx.currentTime);
            gain.gain.setValueAtTime(0.15, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.05);
            osc.start(ctx.currentTime);
            osc.stop(ctx.currentTime + 0.05);
        } catch(e) {}
    }

    function playWinSound() {
        try {
            const ctx = getAudioCtx();
            const notes = [523, 659, 784, 1047]; // C5, E5, G5, C6
            notes.forEach((freq, i) => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.type = 'sine';
                osc.frequency.setValueAtTime(freq, ctx.currentTime + i * 0.15);
                gain.gain.setValueAtTime(0.3, ctx.currentTime + i * 0.15);
                gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + i * 0.15 + 0.4);
                osc.start(ctx.currentTime + i * 0.15);
                osc.stop(ctx.currentTime + i * 0.15 + 0.4);
            });
        } catch(e) {}
    }

    function playClickSound() {
        try {
            const ctx = getAudioCtx();
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.type = 'sine';
            osc.frequency.setValueAtTime(600, ctx.currentTime);
            gain.gain.setValueAtTime(0.1, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.08);
            osc.start(ctx.currentTime);
            osc.stop(ctx.currentTime + 0.08);
        } catch(e) {}
    }

    // === CONFETTI BURST ===
    function fireConfetti() {
        const duration = 4000;
        const end = Date.now() + duration;

        (function frame() {
            confetti({
                particleCount: 3,
                angle: 60,
                spread: 55,
                origin: { x: 0, y: 0.7 },
                colors: ['#ec4899', '#f59e0b', '#8b5cf6', '#10b981', '#f43f5e']
            });
            confetti({
                particleCount: 3,
                angle: 120,
                spread: 55,
                origin: { x: 1, y: 0.7 },
                colors: ['#ec4899', '#f59e0b', '#8b5cf6', '#10b981', '#f43f5e']
            });

            if (Date.now() < end) {
                requestAnimationFrame(frame);
            }
        })();

        // Big center burst
        confetti({
            particleCount: 100,
            spread: 100,
            origin: { y: 0.6 },
            colors: ['#ec4899', '#f59e0b', '#8b5cf6', '#10b981', '#f43f5e']
        });
    }

    // === SOUND HELPERS ===
    function note(ctx, freq, start, dur, vol = 0.2, type = 'sawtooth') {
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();
        const filter = ctx.createBiquadFilter();
        osc.type = type;
        osc.frequency.setValueAtTime(freq, ctx.currentTime + start);
        filter.type = 'lowpass';
        filter.frequency.setValueAtTime(2500, ctx.currentTime + start);
        gain.gain.setValueAtTime(0, ctx.currentTime + start);
        gain.gain.linearRampToValueAtTime(vol, ctx.currentTime + start + 0.03);
        gain.gain.setValueAtTime(vol, ctx.currentTime + start + dur - 0.05);
        gain.gain.linearRampToValueAtTime(0, ctx.currentTime + start + dur);
        osc.connect(filter); filter.connect(gain); gain.connect(ctx.destination);
        osc.start(ctx.currentTime + start); osc.stop(ctx.currentTime + start + dur);
    }

    function cymbal(ctx, time, vol = 0.2) {
        const buf = ctx.createBuffer(1, ctx.sampleRate * 1.2, ctx.sampleRate);
        const d = buf.getChannelData(0);
        for (let i = 0; i < buf.length; i++) d[i] = (Math.random() * 2 - 1) * Math.pow(1 - i / buf.length, 1.5);
        const src = ctx.createBufferSource(); src.buffer = buf;
        const hpf = ctx.createBiquadFilter(); hpf.type = 'highpass'; hpf.frequency.value = 4000;
        const g = ctx.createGain(); g.gain.setValueAtTime(vol, time); g.gain.exponentialRampToValueAtTime(0.001, time + 1.2);
        src.connect(hpf); hpf.connect(g); g.connect(ctx.destination);
        src.start(time); src.stop(time + 1.2);
    }

    function applause(ctx, delay = 0, dur = 3) {
        for (let layer = 0; layer < 3; layer++) {
            for (let i = 0; i < 35; i++) {
                const t = delay + (i / 35) * dur;
                const time = ctx.currentTime + t + Math.random() * 0.1;
                const env = Math.sin(((t - delay) / dur) * Math.PI);
                if (env < 0.05) continue;
                const bs = Math.floor(ctx.sampleRate * 0.025);
                const b = ctx.createBuffer(1, bs, ctx.sampleRate);
                const d = b.getChannelData(0);
                for (let j = 0; j < bs; j++) d[j] = (Math.random() * 2 - 1) * Math.pow(1 - j / bs, 3);
                const s = ctx.createBufferSource(); s.buffer = b;
                const f = ctx.createBiquadFilter(); f.type = 'bandpass'; f.frequency.value = 900 + layer * 500 + Math.random() * 800;
                const g = ctx.createGain(); g.gain.setValueAtTime((0.2 + Math.random() * 0.3) * env, time); g.gain.exponentialRampToValueAtTime(0.001, time + 0.04);
                s.connect(f); f.connect(g); g.connect(ctx.destination); s.start(time); s.stop(time + 0.05);
            }
        }
    }

    // === VARIASI 1: Award Show (da-da-da DAAAA!) ===
    function celebration1() {
        const ctx = getAudioCtx();
        note(ctx, 392, 0, 0.12, 0.25); note(ctx, 392, 0.15, 0.12, 0.25); note(ctx, 392, 0.3, 0.12, 0.25);
        note(ctx, 523, 0.5, 0.7, 0.35); note(ctx, 330, 0.5, 0.7, 0.15); note(ctx, 392, 0.5, 0.7, 0.15);
        note(ctx, 587, 1.3, 0.2, 0.25); note(ctx, 659, 1.55, 0.2, 0.25);
        note(ctx, 784, 1.8, 0.9, 0.35); note(ctx, 659, 1.8, 0.9, 0.2); note(ctx, 523, 1.8, 0.9, 0.15);
        cymbal(ctx, ctx.currentTime + 0.5);
        applause(ctx, 1.0, 3.5);
    }

    // === VARIASI 2: Game Show Ding-Ding-Ding! ===
    function celebration2() {
        const ctx = getAudioCtx();
        // Rapid ascending dings
        [880, 1047, 1175, 1319, 1568].forEach((f, i) => {
            note(ctx, f, i * 0.1, 0.3, 0.2, 'sine');
        });
        // Big chord
        note(ctx, 523, 0.6, 1.0, 0.3); note(ctx, 659, 0.6, 1.0, 0.25); note(ctx, 784, 0.6, 1.0, 0.25);
        note(ctx, 1047, 0.6, 1.0, 0.2);
        cymbal(ctx, ctx.currentTime + 0.6, 0.3);
        // Sparkle descend
        [1568, 1319, 1175, 1047, 880].forEach((f, i) => {
            note(ctx, f, 1.8 + i * 0.08, 0.15, 0.12, 'sine');
        });
        applause(ctx, 0.8, 3);
    }

    // === VARIASI 3: Stadium Celebration (horns + crowd woo) ===
    function celebration3() {
        const ctx = getAudioCtx();
        // Horn blast
        note(ctx, 349, 0, 0.5, 0.3, 'square'); note(ctx, 440, 0, 0.5, 0.2, 'square');
        note(ctx, 523, 0.5, 0.8, 0.35, 'square'); note(ctx, 659, 0.5, 0.8, 0.25, 'square');
        // Crowd woo sweep
        [200, 260, 320, 180, 240].forEach((f, i) => {
            const d = 1.2 + i * 0.08;
            const osc = ctx.createOscillator(); const g = ctx.createGain(); const fl = ctx.createBiquadFilter();
            osc.type = 'sawtooth'; osc.frequency.setValueAtTime(f, ctx.currentTime + d);
            osc.frequency.linearRampToValueAtTime(f * 2, ctx.currentTime + d + 0.5);
            fl.type = 'bandpass'; fl.frequency.value = 1200; fl.Q.value = 2;
            g.gain.setValueAtTime(0, ctx.currentTime + d); g.gain.linearRampToValueAtTime(0.07, ctx.currentTime + d + 0.15);
            g.gain.linearRampToValueAtTime(0, ctx.currentTime + d + 1.0);
            osc.connect(fl); fl.connect(g); g.connect(ctx.destination);
            osc.start(ctx.currentTime + d); osc.stop(ctx.currentTime + d + 1.1);
        });
        cymbal(ctx, ctx.currentTime + 1.2, 0.25);
        applause(ctx, 1.5, 3.5);
    }

    // === VARIASI 4: Carnival Jingle (upbeat, playful) ===
    function celebration4() {
        const ctx = getAudioCtx();
        // Playful melody: do-mi-sol-do!
        const melody = [
            [523, 0, 0.15], [659, 0.18, 0.15], [784, 0.36, 0.15], [1047, 0.55, 0.4],
            [988, 1.0, 0.12], [880, 1.15, 0.12], [784, 1.3, 0.12],
            [1047, 1.5, 0.6], [784, 1.5, 0.6], [523, 1.5, 0.6],
        ];
        melody.forEach(([f, s, d]) => note(ctx, f, s, d, 0.2, 'sine'));
        // Xylophone sparkle
        [1319, 1568, 1760, 2093].forEach((f, i) => {
            note(ctx, f, 2.2 + i * 0.1, 0.25, 0.15, 'sine');
        });
        cymbal(ctx, ctx.currentTime + 0.55, 0.15);
        applause(ctx, 1.0, 3);
    }

    // === VARIASI 5: Epic Orchestra (dramatic build) ===
    function celebration5() {
        const ctx = getAudioCtx();
        // Drum roll build
        for (let i = 0; i < 25; i++) {
            const t = ctx.currentTime + i * 0.035;
            const o = ctx.createOscillator(); const g = ctx.createGain();
            o.type = 'triangle'; o.frequency.setValueAtTime(140 + Math.random() * 20, t);
            g.gain.setValueAtTime(0.05 + (i / 25) * 0.2, t); g.gain.exponentialRampToValueAtTime(0.001, t + 0.035);
            o.connect(g); g.connect(ctx.destination); o.start(t); o.stop(t + 0.04);
        }
        // Big orchestral hit
        [262, 330, 392, 523, 659].forEach(f => note(ctx, f, 0.95, 1.2, 0.2, 'sawtooth'));
        [262, 330, 392, 523].forEach(f => note(ctx, f, 0.95, 1.2, 0.1, 'square'));
        cymbal(ctx, ctx.currentTime + 0.95, 0.35);
        // Resolve up
        note(ctx, 784, 2.3, 0.2, 0.25); note(ctx, 880, 2.55, 0.2, 0.25);
        note(ctx, 1047, 2.8, 1.0, 0.35); note(ctx, 784, 2.8, 1.0, 0.2); note(ctx, 523, 2.8, 1.0, 0.15);
        cymbal(ctx, ctx.currentTime + 2.8, 0.3);
        applause(ctx, 1.5, 4);
    }

    // === TADA MP3 ===
    let tadaAudio = null;
    function preloadTada() {
        tadaAudio = new Audio('/sounds/tada.mp3');
        tadaAudio.volume = 0.6;
    }
    preloadTada();

    // === PICK RANDOM & PLAY ===
    const celebrations = [celebration1, celebration2, celebration3, celebration4, celebration5];
    let lastCelebration = -1;

    function playWinCelebration() {
        // Pick random, avoid repeat
        let pick;
        do { pick = Math.floor(Math.random() * celebrations.length); } while (pick === lastCelebration);
        lastCelebration = pick;

        // Play selected celebration sound
        try { celebrations[pick](); } catch(e) {}

        // Tada MP3 overlay
        if (tadaAudio) {
            tadaAudio.currentTime = 0;
            tadaAudio.play().catch(() => {});
        }

    }

    // Expose functions globally for Alpine
    window.playTick = playTick;
    window.playWinSound = playWinSound;
    window.playWinCelebration = playWinCelebration;
    window.playClickSound = playClickSound;
    window.fireConfetti = fireConfetti;

    // === BGM ENGINE ===
    const BGM_TYPE = @json($bgmType ?? 'stock');
    const BGM_FILE = @json($bgmFile ? asset('storage/' . $bgmFile) : null);

    let bgmPlaying = false;
    let bgmTimers = [];
    let bgmGain = null;
    let bgmAudio = null; // For MP3 mode

    function bgmLater(fn, ms) {
        const id = setTimeout(() => { if (bgmPlaying) fn(); }, ms);
        bgmTimers.push(id);
        return id;
    }

    function startBGM() {
        if (bgmPlaying || BGM_TYPE === 'off') return;

        if (BGM_TYPE === 'mp3' && BGM_FILE) {
            startMP3();
        } else if (BGM_TYPE === 'stock') {
            startStockBGM();
        }
    }

    // === MP3 MODE ===
    function startMP3() {
        bgmPlaying = true;
        bgmAudio = new Audio(BGM_FILE);
        bgmAudio.loop = true;
        bgmAudio.volume = 0;
        bgmAudio.play().then(() => {
            // Fade in
            let vol = 0;
            const fade = setInterval(() => {
                vol = Math.min(vol + 0.05, 0.6);
                if (bgmAudio) bgmAudio.volume = vol;
                if (vol >= 0.6) clearInterval(fade);
            }, 50);
        }).catch(() => {});
    }

    // === STOCK MODE (Bass + Drums + Arpeggio) ===
    function startStockBGM() {
        const ctx = getAudioCtx();
        if (ctx.state === 'suspended') ctx.resume();
        bgmPlaying = true;

        bgmGain = ctx.createGain();
        bgmGain.gain.setValueAtTime(0, ctx.currentTime);
        bgmGain.gain.linearRampToValueAtTime(0.4, ctx.currentTime + 1.5);
        bgmGain.connect(ctx.destination);

        const BPM = 140;
        const B = 60 / BPM;
        const BAR = B * 4;

        // Helper: synth note
        function synth(freq, start, dur, vol, type, cutoff, attack) {
            const ctx = getAudioCtx();
            const t = ctx.currentTime + start;
            const osc = ctx.createOscillator();
            const g = ctx.createGain();
            const f = ctx.createBiquadFilter();
            osc.type = type || 'sawtooth';
            osc.frequency.setValueAtTime(freq, t);
            f.type = 'lowpass';
            f.frequency.setValueAtTime(cutoff || 2000, t);
            f.Q.value = 1.5;
            const a = attack || 0.01;
            g.gain.setValueAtTime(0, t);
            g.gain.linearRampToValueAtTime(vol, t + a);
            g.gain.setValueAtTime(vol, t + dur - 0.05);
            g.gain.linearRampToValueAtTime(0, t + dur);
            osc.connect(f); f.connect(g); g.connect(bgmGain);
            osc.start(t); osc.stop(t + dur + 0.01);
        }

        // Helper: noise hit
        function noise(start, dur, vol, hpFreq) {
            const ctx = getAudioCtx();
            const t = ctx.currentTime + start;
            const len = Math.floor(ctx.sampleRate * dur);
            const buf = ctx.createBuffer(1, len, ctx.sampleRate);
            const d = buf.getChannelData(0);
            for (let i = 0; i < len; i++) d[i] = (Math.random() * 2 - 1) * Math.pow(1 - i / len, 2);
            const src = ctx.createBufferSource(); src.buffer = buf;
            const hp = ctx.createBiquadFilter(); hp.type = 'highpass'; hp.frequency.value = hpFreq || 3000;
            const g = ctx.createGain();
            g.gain.setValueAtTime(vol, t);
            g.gain.exponentialRampToValueAtTime(0.001, t + dur);
            src.connect(hp); hp.connect(g); g.connect(bgmGain);
            src.start(t); src.stop(t + dur + 0.01);
        }

        // Helper: 808 kick
        function kick808(start, vol) {
            const ctx = getAudioCtx();
            const t = ctx.currentTime + start;
            const osc = ctx.createOscillator();
            const g = ctx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(180, t);
            osc.frequency.exponentialRampToValueAtTime(35, t + 0.15);
            g.gain.setValueAtTime(vol || 0.6, t);
            g.gain.setValueAtTime(vol * 0.7, t + 0.1);
            g.gain.exponentialRampToValueAtTime(0.001, t + 0.45);
            osc.connect(g); g.connect(bgmGain);
            osc.start(t); osc.stop(t + 0.5);
            // Click transient
            const osc2 = ctx.createOscillator();
            const g2 = ctx.createGain();
            osc2.type = 'triangle';
            osc2.frequency.setValueAtTime(800, t);
            osc2.frequency.exponentialRampToValueAtTime(100, t + 0.03);
            g2.gain.setValueAtTime(vol * 0.5, t);
            g2.gain.exponentialRampToValueAtTime(0.001, t + 0.04);
            osc2.connect(g2); g2.connect(bgmGain);
            osc2.start(t); osc2.stop(t + 0.05);
        }

        // --- BASS: 808 sub pattern ---
        const bassNotes = [55, 55, 51.91, 58.27];
        let bassBar = 0;
        function bassLoop() {
            if (!bgmPlaying) return;
            const root = bassNotes[bassBar % bassNotes.length];
            bassBar++;
            const pattern = [
                [0, root, B * 1.8, 0.35],
                [B * 2, root, B * 0.8, 0.3],
                [B * 2.75, root * 1.5, B * 0.5, 0.25],
                [B * 3.5, root, B * 0.4, 0.28],
            ];
            pattern.forEach(([s, freq, dur, vol]) => {
                synth(freq, s, dur, vol, 'sawtooth', 180, 0.01);
                synth(freq, s, dur, vol * 0.6, 'sine', 100, 0.01);
            });
            bgmLater(bassLoop, BAR * 1000);
        }
        bassLoop();

        // --- DRUMS: kick + clap + hats ---
        function drumLoop() {
            if (!bgmPlaying) return;
            kick808(0, 0.55);
            kick808(B * 0.75, 0.3);
            kick808(B * 2, 0.5);
            kick808(B * 3, 0.55);
            kick808(B * 3.5, 0.3);
            noise(B * 1, 0.15, 0.3, 2500);
            noise(B * 3, 0.15, 0.35, 2500);
            for (let i = 0; i < 8; i++) {
                const isOpen = (i === 2 || i === 6);
                noise(B * i * 0.5, isOpen ? 0.12 : 0.04, isOpen ? 0.12 : 0.08, isOpen ? 6000 : 9000);
            }
            bgmLater(drumLoop, BAR * 1000);
        }
        drumLoop();

        // --- ARPEGGIO: sparkling high notes ---
        const arpChords = [
            [392, 466, 587, 784, 932],
            [415, 494, 622, 830, 988],
            [466, 554, 698, 932, 1109],
            [392, 494, 587, 784, 988],
        ];
        let arpIdx = 0;
        function arpLoop() {
            if (!bgmPlaying) return;
            const notes = arpChords[arpIdx % arpChords.length];
            arpIdx++;
            for (let i = 0; i < 16; i++) {
                const noteFreq = notes[i % notes.length] * (i >= 10 ? 2 : 1);
                synth(noteFreq, B * i * 0.25, B * 0.2, 0.06, 'sine', 5000, 0.005);
            }
            bgmLater(arpLoop, BAR * 1000);
        }
        bgmLater(() => arpLoop(), BAR * 1000 * 2);
    }

    function stopBGM() {
        bgmPlaying = false;
        bgmTimers.forEach(id => clearTimeout(id));
        bgmTimers = [];
        // Stop stock
        if (bgmGain) {
            try {
                const ctx = getAudioCtx();
                bgmGain.gain.linearRampToValueAtTime(0, ctx.currentTime + 0.3);
            } catch(e) {}
        }
        // Stop MP3
        if (bgmAudio) {
            bgmAudio.pause();
            bgmAudio.currentTime = 0;
            bgmAudio = null;
        }
    }

    function toggleBGM() {
        if (BGM_TYPE === 'off') return;
        const btn = document.getElementById('bgm-toggle');
        if (bgmPlaying) {
            stopBGM();
            btn.textContent = '🔇';
            btn.title = 'Hidupkan Muzik';
        } else {
            startBGM();
            btn.textContent = '🔊';
            btn.title = 'Matikan Muzik';
        }
    }

    // Auto-start BGM on first user interaction
    if (BGM_TYPE !== 'off') {
        let bgmAutoStarted = false;
        function autoStartBGM() {
            if (bgmAutoStarted) return;
            bgmAutoStarted = true;
            startBGM();
            const btn = document.getElementById('bgm-toggle');
            if (btn) btn.textContent = '🔊';
            document.removeEventListener('click', autoStartBGM);
            document.removeEventListener('touchstart', autoStartBGM);
        }
        document.addEventListener('click', autoStartBGM);
        document.addEventListener('touchstart', autoStartBGM);
    }
    </script>

    @stack('scripts')
</body>
</html>
