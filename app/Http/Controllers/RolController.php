<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Inertia\Inertia;

class RolController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->paginate(15);

        return Inertia::render('Rol/Index', [
            'roles' => $roles
        ]);
    }

    public function create()
    {
        return Inertia::render('Rol/CreateRol');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:50|unique:roles',
            'description' => 'nullable|string|max:255',
        ]);

        Role::create($validated);

        return redirect()->route('roles.index')
            ->with('success', 'Rol creado correctamente.');
    }

    public function edit(string $id)
    {
        $role = Role::withCount('users')->findOrFail($id);

        return Inertia::render('Rol/EditRol', [
            'role' => $role
        ]);
    }

    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:50|unique:roles,name,' . $role->id,
            'description' => 'nullable|string|max:255',
        ]);

        $role->update($validated);

        return redirect()->route('roles.index')
            ->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);

        if ($role->users()->exists()) {
            return back()->with('error', 'No puedes eliminar un rol con usuarios asignados.');
        }

        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Rol eliminado correctamente.');
    }
}