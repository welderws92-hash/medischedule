<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gerenciamento de Médicos
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Médicos cadastrados
                    </h3>

                    <span class="text-sm text-gray-500">
                        Total: {{ $doctors->total() }}
                    </span>
                </div>

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Médico</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">E-mail</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">CRM</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Especialidade</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Situação
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($doctors as $doctor)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-800">
                                        {{ $doctor->user->name }}
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        {{ $doctor->user->email }}
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        {{ $doctor->crm }}
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        {{ $doctor->specialty->name }}
                                    </td>

                                    <td class="px-4 py-3 text-sm">
                                        @if ($doctor->is_active)
                                            <span class="px-2 py-1 rounded bg-green-100 text-green-800">
                                                Ativo
                                            </span>
                                        @else
                                            <span class="px-2 py-1 rounded bg-red-100 text-red-800">
                                                Inativo
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                        Nenhum médico cadastrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $doctors->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>