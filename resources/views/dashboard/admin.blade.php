<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Painel Administrativo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Saudação -->
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-2xl font-bold text-gray-800">
                    Olá, {{ auth()->user()->name }}!
                </h3>
                <p class="mt-2 text-gray-600">
                    Bem-vindo ao MediSchedule. Gerencie o sistema em um só lugar.
                </p>
            </div>

            <!-- Indicadores -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-800">Médicos</h3>
                    <p class="mt-2 text-gray-500">
                        Gerenciamento dos profissionais.
                    </p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-800">Pacientes</h3>
                    <p class="mt-2 text-gray-500">
                        Gerenciamento dos pacientes cadastrados.
                    </p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-800">Consultas</h3>
                    <p class="mt-2 text-gray-500">
                        Acompanhamento dos agendamentos.
                    </p>
                </div>

            </div>

            <!-- Gerenciamento -->
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800">
                    Gestão de profissionais
                </h3>
                <p class="mt-2 text-gray-600">
                    Aqui ficará disponível o gerenciamento dos médicos e suas especialidades.
                </p>
                <p class="mt-4 text-sm text-gray-500">
                    Funcionalidade em desenvolvimento.
                </p>
            </div>

            <!-- Consultas -->
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800">
                    Gestão de consultas
                </h3>
                <p class="mt-2 text-gray-600">
                    Aqui ficará disponível o acompanhamento das consultas do sistema.
                </p>
                <p class="mt-4 text-sm text-gray-500">
                    Funcionalidade em desenvolvimento.
                </p>
            </div>

        </div>
    </div>
</x-app-layout>