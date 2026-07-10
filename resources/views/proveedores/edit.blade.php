<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Proveedor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form method="POST" action="{{ route('proveedores.update', $proveedore) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="razon_social" :value="__('Razón Social')" />
                        <x-text-input id="razon_social" name="razon_social" type="text" class="mt-1 block w-full" 
                            value="{{ old('razon_social', $proveedore->razon_social) }}" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('razon_social')" />
                    </div>

                    <div>
                        <x-input-label for="nit" :value="__('NIT')" />
                        <x-text-input id="nit" name="nit" type="text" class="mt-1 block w-full" 
                            value="{{ old('nit', $proveedore->nit) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('nit')" />
                    </div>

                    <div>
                        <x-input-label for="telefono" :value="__('Teléfono')" />
                        <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" 
                            value="{{ old('telefono', $proveedore->telefono) }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" 
                            value="{{ old('email', $proveedore->email) }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="direccion" :value="__('Dirección')" />
                        <x-text-input id="direccion" name="direccion" type="text" class="mt-1 block w-full" 
                            value="{{ old('direccion', $proveedore->direccion) }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('direccion')" />
                    </div>

                    <div>
                        <x-input-label for="estado" :value="__('Estado del Proveedor')" />
                        <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                            <option value="1" {{ old('estado', $proveedore->estado) == 1 ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('estado', $proveedore->estado) == 0 ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('estado')" />
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        </div>

                    <div class="flex items-center justify-end space-x-3 ">
                        <a href="{{ route('proveedores.index') }}" class="text-gray-600 dark:text-gray-400 text-sm hover:underline">
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