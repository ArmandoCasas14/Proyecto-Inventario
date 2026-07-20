<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->search, fn($q, $s) => $q->where('name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%"))
            ->when($request->role_id, fn($q, $id) => $q->where('role_id', $id))
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();

        $roles = Role::all();
        return view('users.index', compact('users', 'roles'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|max:45|unique:users,email,' . $user->id,
            'role_id'   => 'required|exists:roles,id',
            'status'    => 'required|boolean',
        ]);

        $user->update($request->only(['name', 'email', 'role_id', 'status']));

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }
    // Guarda el nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:45|unique:users,email',
            'role_id'  => 'required|exists:roles,id',
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()       // Exige al menos una letra
                    ->mixedCase()     // Exige al menos una mayúscula y una minúscula
                    ->numbers()       // Exige al menos un número
                    ->symbols()       // Exige al menos un carácter especial (!@#$%^&*...)
                    // ->uncompromised() // Opcional: verifica que la contraseña n o haya sido filtrada en hackeos de internet
            ],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role_id'  => $request->role_id,
            'password' => Hash::make($request->password),
            'status'   => 1,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }
}
