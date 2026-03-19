<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')
            ->select('id', 'username', 'email', 'created_at')
            ->paginate(15);

        return Inertia::render('User/IndexUser', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $roles = Role::all();

        return Inertia::render('User/CreateUser', [
    'roles' => $roles
]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:50|unique:users',
            'email'    => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles'    => 'nullable|array',
            'roles.*'  => 'exists:roles,id',
        ]);

        $user = User::create([
            'username' => $validatedData['username'],
            'email'    => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Asignar roles si se han seleccionado
        if (!empty($validatedData['roles'])) {
            $user->roles()->sync($validatedData['roles']);
        }

        // Crear configuración por defecto
        $user->config()->create([
            'audio_volume' => 100,
            'video_scale'  => 1,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();

        return Inertia::render('User/EditUser', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
     $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'email'    => 'required|email|max:100|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles'    => 'nullable|array',
            'roles.*'  => 'exists:roles,id',
        ]);

        $user->update([
            'username' => $validated['username'],
            'email'    => $validated['email'],
            ...(isset($validated['password'])
                ? ['password' => Hash::make($validated['password'])]
                : []),
        ]);

        // Sincronizar roles (vacío si no se pasan)
        $user->roles()->sync($validated['roles'] ?? []);

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
       $authUser = auth()->user();

        if ($authUser && $authUser->getKey() === $user->getKey()) {
            return back()->with('error', 'No puedes eliminarte a ti mismo.');
        }
        

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
