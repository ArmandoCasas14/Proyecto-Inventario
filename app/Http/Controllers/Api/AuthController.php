<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:45|unique:users',
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()       // Exige al menos una letra
                    ->mixedCase()     // Exige al menos una mayúscula y una minúscula
                    ->numbers()       // Exige al menos un número
                    ->symbols()       // Exige al menos un carácter especial (!@#$%^&*...)
                    // ->uncompromised() // Opcional: verifica que la contraseña no haya sido filtrada en hackeos de internet
            ],
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role_id' => $validated['role_id'],
        ]);
        if (!$user->id) {
            return response()->json(['error' => 'Usuario no se creó'], 500);
        }   

        $token = auth('api')->login($user);
        return $this->respondWithToken($token);

        if (!$token) {
            return response()->json(['error' => 'No se pudo generar el token'], 500);
        }
    }
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        return $this->respondWithToken($token);
    }
    public function me()
    {
        return response()->json(auth('api')->user());
    }
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }
    public function index()
    {
        // Solo el administrador debe poder ver la lista completa
        if (auth('api')->user()->role->name !== 'Administrador') {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        // Retornamos los usuarios con su rol cargado
        return response()->json(User::with('role')->get());
    }
    public function show($id)
    {
        // Solo permitimos ver si eres tú mismo o si eres administrador
        $user = User::findOrFail($id);
        
        if (auth('api')->user()->id !== $user->id && auth('api')->user()->role->name !== 'Administrador') {
            return response()->json(['error' => 'No tienes permiso'], 403);
        }

        return response()->json($user);
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $authenticatedUser = auth('api')->user();

        // 1. Verificación de permisos
        if ($authenticatedUser->id !== $user->id && $authenticatedUser->role->name !== 'Administrador') {
            return response()->json(['error' => 'No tienes permiso'], 403);
        }

        // 2. Definir qué campos puede editar
        $rules = [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => [
                'sometimes',
                'required', // Se asegura de que si se envía, no venga vacía
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
        ];

        // Solo el administrador puede modificar el rol
        if ($authenticatedUser->role->name === 'Administrador') {
            $rules['role_id'] = 'sometimes|exists:roles,id';
        }

        $validated = $request->validate($rules);

        // 3. Procesar contraseña si existe
        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);

        return response()->json(['message' => 'Usuario actualizado correctamente', 'user' => $user]);
    }
}
