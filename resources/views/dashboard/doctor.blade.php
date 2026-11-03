<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Painel do Médico
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Saudação -->
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-2xl font-bold text-gray-800">
                    Olá, Dr(a). {{ auth()->user()->name }}!
                </h3>
                <p class="mt-2 text-gray-600">
                    Bem-vindo ao MediSchedule. Gerencie sua agenda e acompanhe seus pacientes.
                </p>
            </div>

            <!-- Resumo -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-800">Consultas de hoje</h3>
                    <p class="mt-2 text-gray-500">
                        Área de consultas do dia.
                    </p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-800">Minha agenda</h3>
                    <p class="mt-2 text-gray-500">
                        Visualize seus horários disponíveis.
                    </p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-800">Meus pacientes</h3>
                    <p class="mt-2 text-gray-500">
                        Consulte a lista de pacientes.
                    </p>
                </div>

            </div>

            <!-- Agenda -->
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800">
                    Próximas consultas
                </h3>
                <p class="mt-2 text-gray-600">
                    Aqui serão exibidos seus próximos agendamentos.
                </p>
                <p class="mt-4 text-sm text-gray-500">
                    Funcionalidade em desenvolvimento.
                </p>
            </div>

            <!-- Histórico -->
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800">
                    Histórico de atendimentos
                </h3>
                <p class="mt-2 text-gray-600">
                    Aqui ficará disponível o histórico dos atendimentos realizados.
                </p>
            </div>

        </div>
    </div>
</x-app-layout>