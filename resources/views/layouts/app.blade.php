<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Dompetku{{ isset($title) ? ' | ' . $title : '' }}</title>

        <!-- Apply dark mode class before first paint to avoid flash / mismatched theming -->
        <script>
            (function () {
                const stored = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (stored ? stored === 'dark' : prefersDark) {
                    document.documentElement.classList.add('dark');
                }
            })();
            function toggleTheme() {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
            }
        </script>

        <!-- Fonts: Plus Jakarta Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Handcrafted Glassmorphism Custom Theme Styles -->
        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif !important;
            }

            /* Gen-Z Bento Grid Card Style — warm nude glass */
            .glass-card {
                background: rgba(255, 253, 249, 0.65) !important;
                backdrop-filter: blur(14px) !important;
                -webkit-backdrop-filter: blur(14px) !important;
                border: 2px solid rgba(204, 107, 69, 0.12) !important;
                border-radius: 1.5rem !important; /* rounded-3xl */
            }

            .dark .glass-card {
                background: rgba(41, 31, 26, 0.6) !important;
                backdrop-filter: blur(14px) !important;
                -webkit-backdrop-filter: blur(14px) !important;
                border: 2px solid rgba(237, 173, 143, 0.08) !important;
                border-radius: 1.5rem !important; /* rounded-3xl */
            }

            .glass-modal {
                background: rgba(255, 253, 249, 0.88) !important;
                backdrop-filter: blur(20px) !important;
                -webkit-backdrop-filter: blur(20px) !important;
                border: 2px solid rgba(204, 107, 69, 0.18) !important;
                border-radius: 1.5rem !important;
                box-shadow: 0 25px 50px -12px rgba(173, 86, 54, 0.25) !important;
            }

            .dark .glass-modal {
                background: rgba(41, 31, 26, 0.9) !important;
                backdrop-filter: blur(20px) !important;
                -webkit-backdrop-filter: blur(20px) !important;
                border: 2px solid rgba(237, 173, 143, 0.12) !important;
                border-radius: 1.5rem !important;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
            }

            /* Floating Keyframes Animation */
            @keyframes float {
                0% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-10px) rotate(2deg); }
                100% { transform: translateY(0px) rotate(0deg); }
            }
            .float-animation {
                animation: float 5s ease-in-out infinite;
            }

            /* Glow effects — nude/pastel */
            .glow-clay {
                box-shadow: 0 10px 25px -5px rgba(204, 107, 69, 0.2), 0 8px 10px -6px rgba(204, 107, 69, 0.2);
            }
            .glow-sage {
                box-shadow: 0 10px 25px -5px rgba(127, 148, 87, 0.2), 0 8px 10px -6px rgba(127, 148, 87, 0.2);
            }
            .glow-blush {
                box-shadow: 0 10px 25px -5px rgba(200, 91, 109, 0.2), 0 8px 10px -6px rgba(200, 91, 109, 0.2);
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col bg-gradient-to-br from-sand-50 via-blush-50/50 to-clay-50/40 dark:from-stone-950 dark:via-stone-900 dark:to-stone-950 text-stone-800 dark:text-stone-100 transition-colors duration-300">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white/40 dark:bg-stone-900/40 backdrop-blur-md border-b border-clay-100 dark:border-stone-800/60 shadow-sm">
                    <div class="max-w-screen-xl mx-auto py-4 px-4 sm:px-6 lg:px-10">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-grow min-h-[60vh]">
                {{ $slot }}
            </main>

            <!-- Footer: only shown on pages that opt-in -->
            @isset($footer)
            <footer class="bg-white/30 dark:bg-stone-950/30 backdrop-blur-md border-t border-clay-100/50 dark:border-stone-800/50 py-5 mt-auto">
                <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-10 flex items-center justify-center text-center text-xs font-semibold text-stone-500 dark:text-stone-400">
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                        <span class="inline-flex items-center justify-center rounded-xl bg-gradient-to-br from-clay-400 to-blush-400 text-white shadow-sm" style="width:1.75rem;height:1.75rem;min-width:1.75rem;min-height:1.75rem;">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5A2.5 2.5 0 015.5 5h11A2.5 2.5 0 0119 7.5v9a2.5 2.5 0 01-2.5 2.5h-11A2.5 2.5 0 013 16.5v-9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a1.25 1.25 0 100-2.5 1.25 1.25 0 000 2.5z"/>
                            </svg>
                        </span>
                        <span>Dompetku &copy; {{ date('Y') }} &nbsp;·&nbsp; {{ __('Dibuat dengan Laravel & 🤎') }}</span>
                    </div>
                </div>
            </footer>
            @endisset
        </div>

        <!-- Floating Action Button (FAB) -->
        <a href="javascript:void(0)" onclick="handleFabClick()"
           class="fixed bottom-6 right-6 z-40 flex items-center justify-center w-14 h-14 rounded-full bg-clay-500 hover:bg-clay-600 text-white shadow-xl hover:shadow-2xl transition-all duration-300 active:scale-90 transform hover:scale-110 glow-clay cursor-pointer"
           title="Tambah Transaksi Baru">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
        </a>

        <script>
            function handleFabClick() {
                if (typeof openCreateModal === 'function') {
                    openCreateModal();
                } else {
                    window.location.href = "{{ route('transactions.index', ['create' => 1]) }}";
                }
            }
        </script>

        <!-- Custom Confirm Modal -->
        <div id="confirm-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-stone-900/40 backdrop-blur-sm" onclick="closeConfirmModal()"></div>
            
            <!-- Modal Box -->
            <div id="confirm-modal-box" class="relative z-10 w-full max-w-sm transform scale-95 opacity-0 transition-all duration-300 ease-out glass-modal p-6 text-center">
                <!-- Icon warning -->
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blush-500/10 text-blush-600 mb-4">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                
                <h3 class="text-md font-extrabold text-stone-800 dark:text-stone-200 mb-2">{{ __('Konfirmasi Tindakan') }}</h3>
                <p id="confirm-modal-message" class="text-sm text-stone-500 dark:text-stone-400 mb-6"></p>
                
                <div class="flex justify-center gap-3">
                    <button type="button" onclick="closeConfirmModal()"
                            class="flex-1 rounded-full bg-stone-100 hover:bg-stone-200 dark:bg-stone-800 dark:hover:bg-stone-700 px-4 py-2 text-sm font-bold text-stone-700 dark:text-stone-300 transition-colors active:scale-95">
                        {{ __('Batal') }}
                    </button>
                    <button id="confirm-modal-btn" type="button"
                            class="flex-1 rounded-full bg-blush-500 hover:bg-blush-600 active:scale-95 transition-all duration-200 text-sm font-bold text-white shadow-sm glow-blush">
                        {{ __('Ya, Hapus') }}
                    </button>
                </div>
            </div>
        </div>

        <script>
            let currentConfirmForm = null;

            function confirmAction(form, message) {
                currentConfirmForm = form;
                const modal = document.getElementById('confirm-modal');
                const modalBox = document.getElementById('confirm-modal-box');
                const msgEl = document.getElementById('confirm-modal-message');
                
                msgEl.innerText = message;
                
                // Show modal
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalBox.classList.remove('scale-95', 'opacity-0');
                    modalBox.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function closeConfirmModal() {
                const modal = document.getElementById('confirm-modal');
                const modalBox = document.getElementById('confirm-modal-box');
                
                modalBox.classList.remove('scale-100', 'opacity-100');
                modalBox.classList.add('scale-95', 'opacity-0');
                
                setTimeout(() => {
                    modal.classList.add('hidden');
                    currentConfirmForm = null;
                }, 300);
            }

            document.getElementById('confirm-modal-btn').addEventListener('click', () => {
                if (currentConfirmForm) {
                    // Temporarily disable onsubmit handler to prevent loop
                    const oldOnsubmit = currentConfirmForm.onsubmit;
                    currentConfirmForm.onsubmit = null;
                    currentConfirmForm.submit();
                }
                closeConfirmModal();
            });
        </script>

        <!-- Floating Toast Container -->
        <div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col gap-3 max-w-sm w-full pointer-events-none px-4 sm:px-0"></div>

        <script>
            // Global Toast Notification System
            function showToast(message, type = 'success') {
                const container = document.getElementById('toast-container');
                const toast = document.createElement('div');
                
                toast.className = `pointer-events-auto flex items-center gap-3 p-4 rounded-xl shadow-lg border transform translate-x-full transition-all duration-300 ease-out glass-modal glow-${type === 'success' ? 'sage' : 'blush'}`;

                const iconColor = type === 'success' ? 'text-sage-500' : 'text-blush-500';
                const iconSvg = type === 'success' 
                    ? `<svg class="w-5 h-5 ${iconColor}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`
                    : `<svg class="w-5 h-5 ${iconColor}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;

                toast.innerHTML = `
                    <div class="flex-shrink-0">${iconSvg}</div>
                    <div class="flex-1 text-sm font-semibold text-stone-800 dark:text-stone-200">${message}</div>
                    <button class="flex-shrink-0 text-stone-400 hover:text-stone-600 dark:hover:text-stone-200 transition-colors" onclick="this.parentElement.classList.add('translate-x-full', 'opacity-0'); setTimeout(() => { this.parentElement.remove() }, 300)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                `;

                container.appendChild(toast);

                // Slide in
                setTimeout(() => {
                    toast.classList.remove('translate-x-full');
                }, 10);

                // Auto remove after 3.5 seconds
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.classList.add('translate-x-full', 'opacity-0');
                        setTimeout(() => {
                            toast.remove();
                        }, 300);
                    }
                }, 3500);
            }

            // Detect session message on page load
            @if(session('success'))
                window.addEventListener('DOMContentLoaded', () => {
                    showToast("{{ session('success') }}", 'success');
                });
            @endif
        </script>
        <!-- Canvas for Confetti Coin Rain -->
        <canvas id="confettiCanvas" class="fixed inset-0 pointer-events-none z-50 w-full h-full hidden"></canvas>

        <script>
            // Global Web Audio API Synthesizer
            const AudioSynth = {
                ctx: null,
                init() {
                    if (!this.ctx) {
                        this.ctx = new (window.AudioContext || window.webkitAudioContext)();
                    }
                },
                playCoin() {
                    try {
                        this.init();
                        const now = this.ctx.currentTime;
                        
                        // Osc 1 (Low metal clink)
                        const osc1 = this.ctx.createOscillator();
                        const gain1 = this.ctx.createGain();
                        osc1.type = 'sine';
                        osc1.frequency.setValueAtTime(850, now);
                        osc1.frequency.exponentialRampToValueAtTime(1200, now + 0.08);
                        gain1.gain.setValueAtTime(0.2, now);
                        gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.25);
                        osc1.connect(gain1);
                        gain1.connect(this.ctx.destination);
                        
                        // Osc 2 (High chime)
                        const osc2 = this.ctx.createOscillator();
                        const gain2 = this.ctx.createGain();
                        osc2.type = 'sine';
                        osc2.frequency.setValueAtTime(1500, now + 0.06);
                        osc2.frequency.exponentialRampToValueAtTime(2000, now + 0.2);
                        gain2.gain.setValueAtTime(0.15, now + 0.06);
                        gain2.gain.exponentialRampToValueAtTime(0.001, now + 0.35);
                        osc2.connect(gain2);
                        gain2.connect(this.ctx.destination);
                        
                        osc1.start(now);
                        osc1.stop(now + 0.3);
                        osc2.start(now + 0.06);
                        osc2.stop(now + 0.4);
                    } catch (e) {
                        console.error('AudioContext fail:', e);
                    }
                },
                playSwoosh() {
                    try {
                        this.init();
                        const now = this.ctx.currentTime;
                        const bufferSize = this.ctx.sampleRate * 0.3; // 0.3s
                        const buffer = this.ctx.createBuffer(1, bufferSize, this.ctx.sampleRate);
                        const data = buffer.getChannelData(0);
                        
                        for (let i = 0; i < bufferSize; i++) {
                            data[i] = Math.random() * 2 - 1;
                        }
                        
                        const noise = this.ctx.createBufferSource();
                        noise.buffer = buffer;
                        
                        const filter = this.ctx.createBiquadFilter();
                        filter.type = 'bandpass';
                        filter.frequency.setValueAtTime(800, now);
                        filter.frequency.exponentialRampToValueAtTime(150, now + 0.3);
                        
                        const gain = this.ctx.createGain();
                        gain.gain.setValueAtTime(0.15, now);
                        gain.gain.exponentialRampToValueAtTime(0.001, now + 0.3);
                        
                        noise.connect(filter);
                        filter.connect(gain);
                        gain.connect(this.ctx.destination);
                        
                        noise.start(now);
                        noise.stop(now + 0.3);
                    } catch (e) {
                        console.error('AudioContext fail:', e);
                    }
                },
                playTransfer() {
                    try {
                        this.init();
                        const now = this.ctx.currentTime;
                        
                        const osc = this.ctx.createOscillator();
                        const gain = this.ctx.createGain();
                        osc.type = 'triangle';
                        osc.frequency.setValueAtTime(440, now);
                        osc.frequency.setValueAtTime(660, now + 0.06);
                        osc.frequency.setValueAtTime(880, now + 0.12);
                        
                        gain.gain.setValueAtTime(0.1, now);
                        gain.gain.exponentialRampToValueAtTime(0.001, now + 0.22);
                        
                        osc.connect(gain);
                        gain.connect(this.ctx.destination);
                        
                        osc.start(now);
                        osc.stop(now + 0.22);
                    } catch (e) {
                        console.error('AudioContext fail:', e);
                    }
                }
            };

            // Global Canvas Confetti system (Coin Rain)
            const CoinConfetti = {
                canvas: null,
                ctx: null,
                particles: [],
                animationId: null,
                init() {
                    this.canvas = document.getElementById('confettiCanvas');
                    this.ctx = this.canvas.getContext('2d');
                    this.resizeCanvas();
                    window.removeEventListener('resize', this.resizeCanvas);
                    window.addEventListener('resize', () => this.resizeCanvas());
                },
                resizeCanvas() {
                    if (this.canvas) {
                        this.canvas.width = window.innerWidth;
                        this.canvas.height = window.innerHeight;
                    }
                },
                start() {
                    this.init();
                    this.canvas.classList.remove('hidden');
                    this.particles = [];
                    const count = 55;
                    for (let i = 0; i < count; i++) {
                        this.particles.push({
                            x: Math.random() * this.canvas.width,
                            y: -Math.random() * 200 - 50,
                            radius: Math.random() * 8 + 6,
                            color: Math.random() > 0.5 ? '#F59E0B' : '#FBBF24', // Gold tones
                            speedY: Math.random() * 5 + 4,
                            speedX: Math.random() * 3 - 1.5,
                            rotation: Math.random() * 360,
                            rotationSpeed: Math.random() * 8 - 4,
                            opacity: 1
                        });
                    }
                    if (this.animationId) {
                        cancelAnimationFrame(this.animationId);
                    }
                    this.animate();
                },
                animate() {
                    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                    let active = false;
                    this.particles.forEach(p => {
                        if (p.y < this.canvas.height + 50) {
                            active = true;
                            p.y += p.speedY;
                            p.x += p.speedX;
                            p.rotation += p.rotationSpeed;
                            
                            this.ctx.save();
                            this.ctx.translate(p.x, p.y);
                            this.ctx.rotate((p.rotation * Math.PI) / 180);
                            
                            // Draw gold coin ellipse
                            this.ctx.beginPath();
                            this.ctx.ellipse(0, 0, p.radius, p.radius * 0.6, 0, 0, 2 * Math.PI);
                            this.ctx.fillStyle = p.color;
                            this.ctx.shadowColor = 'rgba(0,0,0,0.1)';
                            this.ctx.shadowBlur = 3;
                            this.ctx.fill();
                            
                            // Draw inner detail
                            this.ctx.beginPath();
                            this.ctx.ellipse(0, 0, p.radius * 0.5, p.radius * 0.5 * 0.6, 0, 0, 2 * Math.PI);
                            this.ctx.strokeStyle = '#D97706';
                            this.ctx.lineWidth = 1;
                            this.ctx.stroke();
                            
                            this.ctx.restore();
                        }
                    });
                    if (active) {
                        this.animationId = requestAnimationFrame(() => this.animate());
                    } else {
                        this.canvas.classList.add('hidden');
                    }
                }
            };

            // Hook last transaction type redirect session
            @if (session('last_transaction_type'))
                window.addEventListener('DOMContentLoaded', () => {
                    const lastType = "{{ session('last_transaction_type') }}";
                    setTimeout(() => {
                        if (lastType === 'income') {
                            AudioSynth.playCoin();
                            CoinConfetti.start();
                        } else if (lastType === 'expense') {
                            AudioSynth.playSwoosh();
                        } else if (lastType === 'transfer') {
                            AudioSynth.playTransfer();
                        }
                    }, 400); // short delay for visual alignment with toast
                });
            @endif
        </script>

        @stack('scripts')
    </body>
</html>
