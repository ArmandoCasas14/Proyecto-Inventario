<x-guest-layout>
    <div class="min-h-[80vh] flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
        
        <div class="w-full max-w-md bg-white p-8 rounded-3xl shadow-xl border border-gray-100 flex flex-col">
            
            <!-- Icono y Encabezado de Seguridad -->
            <div class="text-center mb-6">
                <div class="mx-auto h-12 w-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Verificación de código</h2>
                <p class="text-sm text-gray-500 mt-2 px-4">
                    Se ha enviado un código de seguridad de un solo uso (OTP) a tu correo electrónico.
                </p>
            </div>

            <!-- Notificación de Éxito (Session Status) -->
            @if(session('status'))
                <div class="mb-5 bg-green-50 border border-green-200/60 p-4 rounded-xl flex items-start gap-3">
                    <span class="text-green-600 text-sm mt-0.5">✓</span>
                    <p class="text-sm text-green-700 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            <!-- Formulario Principal de Verificación -->
            <form action="{{ route('otp.verify.post') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label for="code" class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">
                        Código de 6 dígitos
                    </label>
                    
                    <div class="relative">
                        <input type="text" 
                               name="code" 
                               id="code" 
                               class="w-full tracking-[0.5em] text-center text-xl font-mono font-extrabold bg-gray-50 text-gray-900 placeholder-gray-300 border border-gray-200 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100 rounded-xl py-3.5 transition duration-150" 
                               placeholder="000000"
                               required 
                               autofocus 
                               maxlength="6"
                               autocomplete="one-time-code">
                    </div>

                    @error('code') 
                        <p class="mt-2 text-xs font-semibold text-red-600 flex items-center gap-1">
                            ⚠️ {{ $message }}
                        </p> 
                    @enderror
                </div>

                <button type="submit" 
                        class="w-full inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl shadow-md hover:shadow-lg transition duration-150 text-sm">
                    Verificar Cuenta
                </button>
            </form>

            <hr class="my-6 border-gray-100">

            <!-- Formulario de Reenvío de Código -->
            <div class="text-center">
                <p class="text-xs text-gray-400">¿No recibiste el correo o tu código expiró?</p>
                
                <form action="{{ route('otp.resend') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" 
                            class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition duration-150 focus:outline-none focus:underline">
                        Reenviar nuevo código
                    </button>
                </form>
            </div>

        </div>
        
    </div>
</x-guest-layout>