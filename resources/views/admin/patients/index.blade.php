<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gerenciamento de Pacientes
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold">
                        Pacientes cadastrados
                    </h3>

                    <span class="text-sm text-gray-600">
                        Total: {{ $patients->total() }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Nome
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    E-mail
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    CPF
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Telefone
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Situação
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Ações
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">

                            @forelse ($patients as $patient)
                                <tr>
                                    <td class="px-4 py-3">
                                        {{ $patient->name }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $patient->email }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $patient->cpf ?? 'Não informado' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $patient->phone ?? 'Não informado' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        @if ($patient->is_active)
                                            <span class="text-green-700 font-medium">
                                                Ativo
                                            </span>
                                        @else
                                            <span class="text-red-700 font-medium">
                                                Inativo
                                            </span>
                                        @endif
                                    </td>


                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">

                                            <a href="{{ route('admin.patients.edit', $patient) }}"
                                                class="text-blue-600 hover:text-blue-800 font-medium">
                                                Editar
                                            </a>

                                            <form method="POST" action="{{ route('admin.patients.destroy', $patient) }}"
                                                onsubmit="return confirm('Tem certeza que deseja excluir este paciente?');">
                                                @csrf
                                                <button type="submit"
                                                    class="{{ $patient->is_active ? 'text-red-600' : 'text-green-600' }} font-medium">
                                                    {{ $patient->is_active ? 'Desativar' : 'Ativar' }}
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.patients.destroy', $patient) }}"
                                                onsubmit="return confirm('Tem certeza que deseja excluir este paciente?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="text-red-700 hover:text-red-900 font-medium">
                                                    Excluir
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                        Nenhum paciente cadastrado.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $patients->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>