<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Painel do Paciente
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-2xl font-bold text-gray-800">
                    Olá, {{ auth()->user()->name }}!
                </h3>
                <p class="mt-2 text-gray-600">
                    Bem-vindo ao MediSchedule. Cuide da sua saúde com praticidade.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Agendar consulta
                    </h3>
                    <p class="mt-2 text-gray-600">
                        Encontre um profissional e solicite um horário.
                    </p>
                    <p class="mt-4 text-sm text-gray-500">
                        Funcionalidade em desenvolvimento.
                    </p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Minhas consultas
                    </h3>
                    <p class="mt-2 text-gray-600">
                        Acompanhe seus agendamentos e horários.
                    </p>
                    <p class="mt-4 text-sm text-gray-500">
                        Funcionalidade em desenvolvimento.
                    </p>
                </div>

            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800">
                    Histórico de consultas
                </h3>
                <p class="mt-2 text-gray-600">
                    Aqui ficará disponível o histórico dos seus atendimentos.
                </p>
            </div>

        </div>
    </div>
</x-app-layout>