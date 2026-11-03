<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class DoctorController extends Controller
{
    public function create()
    {
        $specialties = Specialty::orderBy('name')->get();

        return view('admin.doctors.create', compact('specialties'));
    }
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'lowercase', 'max:255', 'unique:users,email'],
            'cpf' => ['required', 'string', 'max:14', 'unique:users,cpf'],
            'phone' => ['required', 'string', 'max:20'],
            'crm' => ['required', 'string', 'max:30', 'unique:doctors,crm'],
            'specialty_id' => ['required', 'exists:specialties,id'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'cpf' => $validated['cpf'],
                'phone' => $validated['phone'],
                'password' => $validated['password'],
                'role' => 'doctor',
            ]);

            Doctor::create([
                'user_id' => $user->id,
                'specialty_id' => $validated['specialty_id'],
                'crm' => $validated['crm'],
                'is_active' => true,
            ]);
        });

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Médico cadastrado com sucesso!');
    }
    public function index()
    {
        $doctors = Doctor::with(['user', 'specialty'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.doctors.index', compact('doctors'));
    }
}