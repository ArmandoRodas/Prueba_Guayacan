<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q     = trim((string) $request->get('q', ''));
        $role  = $request->get('role');      // technician|admin|frontdesk|null
        $state = $request->get('state');     // active|inactive|null

        $users = User::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%");
                });
            })
            ->when($role, fn($q) => $q->where('role', $role))
            ->when($state === 'active', fn($q) => $q->where('is_active', true))
            ->when($state === 'inactive', fn($q) => $q->where('is_active', false))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users', 'q', 'role', 'state'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = ['technician' => 'Técnico', 'admin' => 'Admin', 'frontdesk' => 'Recepción'];
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:190', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'role'  => ['required', Rule::in(['technician', 'admin', 'frontdesk'])],
            // is_active lo tomamos como boolean aparte
        ]);

        $data['is_active'] = $request->boolean('is_active'); // checkbox

        User::create($data);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
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
    public function edit(User $user)
    {
        $roles = ['technician' => 'Técnico', 'admin' => 'Admin', 'frontdesk' => 'Recepción'];
        return view('users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => ['required','string','max:120'],
            'email' => ['nullable','email','max:190', Rule::unique('users','email')->ignore($user->id)],
            'phone' => ['nullable','string','max:30'],
            'role'  => ['required', Rule::in(['technician','admin','frontdesk'])],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
         $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado.');
    }
}
