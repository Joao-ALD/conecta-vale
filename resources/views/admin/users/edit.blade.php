<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome</label>
                            <input type="text" value="{{ $user->name }}"
                                class="block mt-1 w-full bg-gray-100 dark:bg-gray-900" disabled>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" value="{{ $user->email }}"
                                class="block mt-1 w-full bg-gray-100 dark:bg-gray-900" disabled>
                        </div>

                        <div class="mb-4">
                            <label for="role" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nível
                                (Role)</label>
                            <select name="role" id="role"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700"
                                {{ $user->id === Auth::id() ? 'disabled' : '' }}>

                                @foreach($roles as $role)
                                    <option value="{{ $role }}" {{ $user->role == $role ? 'selected' : '' }}>
                                        {{ ucfirst($role) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            @if($user->id === Auth::id())
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Você não pode alterar seu próprio
                                    nível de acesso.</p>
                            @endif
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('admin.users.index') }}"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                                Cancelar
                            </a>

                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-vale-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 transition ease-in-out duration-150"
                                {{ $user->id === Auth::id() ? 'disabled' : '' }}>
                                Atualizar Nível
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>