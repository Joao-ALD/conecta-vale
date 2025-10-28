<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Complete seu Perfil de Vendedor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            @if(session('warning'))
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('warning') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="mb-4 text-gray-600 dark:text-gray-400">
                        Para começar a vender no Conecta Vale, precisamos de algumas informações adicionais.
                    </p>

                    <form action="{{ route('seller.profile.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="store_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome da Loja / Vendedor</label>
                            <input type="text" id="store_name" name="store_name" value="{{ old('store_name') }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700" required autofocus>
                            <x-input-error :messages="$errors->get('store_name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label for="document_type" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tipo de Documento</label>
                            <select name="document_type" id="document_type" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700" required>
                                <option value="cpf" {{ old('document_type') == 'cpf' ? 'selected' : '' }}>CPF</option>
                                <option value="cnpj" {{ old('document_type') == 'cnpj' ? 'selected' : '' }}>CNPJ</option>
                            </select>
                            <x-input-error :messages="$errors->get('document_type')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label for="document_number" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Número do Documento (apenas números)</label>
                            <input type="text" id="document_number" name="document_number" value="{{ old('document_number') }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700" required>
                            <x-input-error :messages="$errors->get('document_number')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Telefone (Opcional)</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700">
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-vale-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 transition ease-in-out duration-150">
                                Salvar Perfil e Começar a Vender
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
