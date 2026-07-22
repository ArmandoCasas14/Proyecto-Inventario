<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center p-4 sm:p-6 lg:p-8 bg-slate-50 relative overflow-hidden">
        
        <!-- Fondo Decorativo Sutil -->
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#059669_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>

        <!-- Branding Superior -->
        <div class="flex items-center gap-3 mb-8 relative z-10">
            <div class="p-2.5 bg-emerald-600 rounded-xl text-white shadow-sm">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-wide text-gray-900 uppercase">StockControl</h1>
                <p class="text-xs text-emerald-700 font-semibold">Sistema de Gestión e Inventarios</p>
            </div>
        </div>

        <!-- Tarjeta Central de OTP -->
        <div class="w-full max-w-md bg-white rounded-3xl shadow-xl border border-emerald-100/60 p-6 sm:p-8 relative z-10 space-y-6">
            
            <!-- Encabezado de la Tarjeta -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-100 text-emerald-700 rounded-2xl mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                    {{ __('Verificación de código') }}
                </h2>
                <p class="mt-2 text-sm text-gray-500 leading-relaxed px-2">
                    {{ __('Ingresa el código OTP de 6 dígitos que enviamos a tu correo electrónico.') }}
                </p>
            </div>

            <!-- Session Status / Mensajes de Éxito -->
            @if(session('status'))
                <div class="bg-emerald-50 border border-emerald-200 p-4 rounded-xl flex items-start gap-3">
                    <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-emerald-800 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            <!-- Reloj Temporizador -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">El código expira en:</span>
                </div>
                <span id="otp-timer" class="text-lg font-mono font-bold text-emerald-700 bg-white px-3 py-1 rounded-lg border border-slate-200 shadow-sm">
                    05:00
                </span>
            </div>

            <!-- Formulario de Verificación -->
            <form action="{{ route('otp.verify.post') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <x-input-label for="code" :value="__('Código de 6 dígitos')" class="text-gray-700 text-xs uppercase font-bold tracking-wider mb-1.5 block" />
                    
                    <div class="relative">
                        <input type="text" 
                               name="code" 
                               id="code" 
                               class="w-full tracking-[0.5em] text-center text-2xl font-mono font-extrabold bg-gray-50 text-gray-900 placeholder-gray-300 border border-gray-300 focus:bg-white focus:border-emerald-600 focus:ring-emerald-600/20 rounded-xl py-3.5 shadow-sm transition duration-150" 
                               placeholder="000000"
                               required 
                               autofocus 
                               maxlength="6"
                               autocomplete="one-time-code">
                    </div>

                    @error('code') 
                        <p class="mt-2 text-xs font-semibold text-rose-600 flex items-center gap-1">
                            ⚠️ {{ $message }}
                        </p> 
                    @enderror
                </div>

                <button type="submit" 
                        id="btn-verify"
                        class="w-full inline-flex justify-center items-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl transition duration-150 shadow-md shadow-emerald-600/20 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span>{{ __('Verificar Cuenta') }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <div class="border-t border-gray-100 pt-4"></div>

            <!-- Formulario de Reenvío de Código -->
            <div class="text-center">
                <p class="text-xs text-gray-500 mb-1.5">¿No recibiste el correo o tu código expiró?</p>
                
                <form action="{{ route('otp.resend') }}" method="POST" id="resend-form">
                    @csrf
                    <button type="submit" 
                            class="text-sm font-bold text-emerald-700 hover:text-emerald-800 transition duration-150 focus:outline-none hover:underline">
                        {{ __('Reenviar nuevo código') }}
                    </button>
                </form>
            </div>

        </div>

        <!-- Footer Copyright -->
        <p class="mt-8 text-xs text-gray-500 relative z-10 text-center">
            &copy; {{ date('Y') }} StockControl System. Todos los derechos reservados.
        </p>

    </div>

    <!-- Script del Temporizador de 5 minutos -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const TOTAL_SECONDS = 5 * 60; // 5 Minutos (300 segundos)
            const timerElement = document.getElementById('otp-timer');
            const codeInput = document.getElementById('code');
            const verifyBtn = document.getElementById('btn-verify');
            const resendForm = document.getElementById('resend-form');

            function formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = seconds % 60;
                return `${String(minutes).padStart(2, '0')}:${String(remainingSeconds).padStart(2, '0')}`;
            }

            let countdown = parseInt(localStorage.getItem('otp_countdown'));
            let lastUpdate = parseInt(localStorage.getItem('otp_last_update'));
            const now = Math.floor(Date.now() / 1000);

            if (isNaN(countdown) || isNaN(lastUpdate)) {
                countdown = TOTAL_SECONDS;
            } else {
                const elapsed = now - lastUpdate;
                countdown = Math.max(0, countdown - elapsed);
            }

            localStorage.setItem('otp_countdown', countdown);
            localStorage.setItem('otp_last_update', now);

            const interval = setInterval(function () {
                if (countdown <= 0) {
                    clearInterval(interval);
                    timerElement.textContent = "00:00";
                    timerElement.classList.remove('text-emerald-700', 'bg-white');
                    timerElement.classList.add('text-rose-600', 'bg-rose-50', 'border-rose-200');
                    
                    codeInput.disabled = true;
                    codeInput.placeholder = "EXPIRADO";
                    codeInput.classList.add('bg-slate-100', 'cursor-not-allowed');
                    verifyBtn.disabled = true;
                    
                    localStorage.removeItem('otp_countdown');
                    localStorage.removeItem('otp_last_update');
                    return;
                }

                timerElement.textContent = formatTime(countdown);
                countdown--;

                localStorage.setItem('otp_countdown', countdown);
                localStorage.setItem('otp_last_update', Math.floor(Date.now() / 1000));
            }, 1000);

            if (resendForm) {
                resendForm.addEventListener('submit', function () {
                    localStorage.setItem('otp_countdown', TOTAL_SECONDS);
                    localStorage.setItem('otp_last_update', Math.floor(Date.now() / 1000));
                });
            }
        });
    </script>
</x-guest-layout>