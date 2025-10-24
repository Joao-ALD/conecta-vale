<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gerenciar Usuários') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Filters -->
                    <div class="mb-6">
                        <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-end space-x-4">
                            <!-- Search Input -->
                            <div class="flex-grow">
                                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pesquisar (Nome, Email, Loja):</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" placeholder="Digite sua busca...">
                            </div>

                            <!-- Role Dropdown -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filtrar por Nível:</label>
                                <select name="role" id="role" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Todos</option>
                                    <option value="usuario" @selected(request('role') === 'usuario')>Usuário</option>
                                    <option value="vendedor" @selected(request('role') === 'vendedor')>Vendedor</option>
                                    <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">Pesquisar</button>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b-2 border-gray-200 dark:border-gray-700">
                                    <th class="py-3 px-4 font-bold">Nome</th>
                                    <th class="py-3 px-4 font-bold">Email</th>
                                    <th class="py-3 px-4 font-bold">Nível (Role)</th>
                                    <th class="py-3 px-4 font-bold">Nome da Loja (se Vendedor)</th>
                                    <th class="py-3 px-4 font-bold text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <td class="py-4 px-4">{{ $user->name }}</td>
                                        <td class="py-4 px-4">{{ $user->email }}</td>
                                        <td class="py-4 px-4 font-medium uppercase text-xs">                                            
                                            @php
                                                $roleClasses = [
                                                    'admin' => 'bg-vale-accent text-white-800',
                                                    'vendedor' => 'bg-vale-primary text-white',
                                                    'usuario' => 'bg-gray-200 text-gray-800',
                                                ];
                                            @endphp
                                            <span class="px-2 py-1 rounded {{ $roleClasses[$user->role] ?? 'bg-gray-200 text-gray-800' }}">
                                                {{ $user->role }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4">{{ $user->sellerProfile->store_name ?? 'N/A' }}</td>
                                        <td class="py-4 px-4 text-right">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Editar</a>

                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Tem certeza que deseja EXCLUIR este usuário? Esta ação é irreversível.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="{{ $user->id === Auth::id() ? '' : 'text-red-600 dark:text-red-400 hover:underline' }}"
                                                    {{ $user->id === Auth::id() ? 'disabled' : '' }} >
                                                    Excluir
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 px-4 text-center">Nenhum usuário encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>