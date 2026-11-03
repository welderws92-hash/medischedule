<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class PatientController extends Controller
{
    public function index(): View
    {
        $patients = User::where('role', 'patient')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.patients.index', compact('patients'));
    }
    public function create(): View
    {
        return view('admin.patients.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'cpf' => ['nullable', 'string', 'max:14', 'unique:users,cpf'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        DB::transaction(function () use ($validated) {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'cpf' => $validated['cpf'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'password' => $validated['password'],
                'role' => 'patient',
            ]);
        });

        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Paciente cadastrado com sucesso!');
    }

    public function edit(User $patient): View
    {
        abort_unless($patient->role === 'patient', 404);

        return view('admin.patients.edit', compact('patient'));
    }
    public function update(Request $request, User $patient): RedirectResponse
    {
        abort_unless($patient->role === 'patient', 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $patient->id],
            'cpf' => ['nullable', 'string', 'max:14', 'unique:users,cpf,' . $patient->id],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $patient->update($validated);

        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Paciente atualizado com sucesso!');
    }
    public function toggleStatus(User $patient): RedirectResponse
    {
        abort_unless($patient->role === 'patient', 404);

        $patient->is_active = !$patient->is_active;
        $patient->save();

        $status = $patient->is_active ? 'ativado' : 'desativado';

        return redirect()
            ->route('admin.patients.index')
            ->with('success', "Paciente {$status} com sucesso!");
    }
    public function destroy(User $patient): RedirectResponse
    {
        abort_unless($patient->role === 'patient', 404);

        if ($patient->appointments()->exists()) {
            return redirect()
                ->route('admin.patients.index')
                ->with('error', 'Este paciente possui consultas vinculadas e não pode ser excluído. Desative o cadastro.');
        }

        $patient->delete();

        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Paciente excluído com sucesso!');
    }
}