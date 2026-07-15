<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Proveedor:') }} <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ $supplier->legal_name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form method="POST" action="{{ route('suppliers.update', $supplier) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="legal_name" :value="__('Razón Social / Nombre Legal')" />
                        <x-text-input id="legal_name" name="legal_name" type="text" class="mt-1 block w-full" 
                            value="{{ old('legal_name', $supplier->legal_name) }}" required placeholder="Ej: Distribuidora S.A.S." />
                        <x-input-error class="mt-2" :messages="$errors->get('legal_name')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="nit" :value="__('NIT / Documento Identificación')" />
                            <x-text-input id="nit" name="nit" type="text" class="mt-1 block w-full" 
                                value="{{ old('nit', $supplier->nit) }}" required placeholder="Ej: 900.123.456-1" />
                            <x-input-error class="mt-2" :messages="$errors->get('nit')" />
                        </div>

                        <div>
                            <x-input-label for="phone" :value="__('Teléfono de Contacto')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" 
                                value="{{ old('phone', $supplier->phone) }}" placeholder="Ej: +57 300 123 4567" />
                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="email" :value="__('Correo Electrónico')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" 
                                value="{{ old('email', $supplier->email) }}" placeholder="contacto@proveedor.com" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('Dirección')" />
                            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" 
                                value="{{ old('address', $supplier->address) }}" placeholder="Ej: Calle 10 #15-20" />
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>
                    </div>

                    <div class="max-w-xs">
                        <x-input-label for="status" :value="__('Estado')" />
                        <select id="status" name="status" required
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="1" {{ old('status', $supplier->status) == '1' ? 'selected' : '' }}>{{ __('Activo') }}</option>
                            <option value="0" {{ old('status', $supplier->status) == '0' ? 'selected' : '' }}>{{ __('Inactivo') }}</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('status')" />
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('suppliers.index') }}" class="text-gray-600 dark:text-gray-400 text-sm hover:underline">
                            {{ __('Cancelar') }}
                        </a>
                        <x-primary-button>
                            {{ __('Actualizar Proveedor') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>