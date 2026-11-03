<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar paciente
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('admin.patients.update', $patient) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name">Nome completo</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $patient->name) }}" required
                            class="block w-full mt-1 rounded-md border-gray-300">
                        @error('name')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email">E-mail</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $patient->email) }}" required
                            class="block w-full mt-1 rounded-md border-gray-300">
                        @error('email')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="cpf">CPF</label>
                        <input id="cpf" name="cpf" type="text" value="{{ old('cpf', $patient->cpf) }}"
                            class="block w-full mt-1 rounded-md border-gray-300">
                        @error('cpf')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="phone">Telefone</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone', $patient->phone) }}"
                            class="block w-full mt-1 rounded-md border-gray-300">
                        @error('phone')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('admin.patients.index') }}" class="px-4 py-2 bg-gray-200 rounded-md">
                            Cancelar
                        </a>

                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                            Salvar alterações
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>