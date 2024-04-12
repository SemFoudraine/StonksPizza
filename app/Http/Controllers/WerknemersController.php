<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Log;

class WerknemersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('users')->get();  // Haalt alle rollen op met hun gerelateerde gebruikers
        $employees = User::with('roles')->get()->groupBy('roles.name');

        $rolesCount = $employees->map(function ($group) {
            return count($group);
        });

        return view('beheer.werknemers.index', compact('roles', 'employees', 'rolesCount'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function assignRole(Request $request)
    {
        $user = User::where('email', $request->user_email)->firstOrFail();
        $role = Role::findOrFail($request->role_id);
        $user->roles()->attach($role);
        return back()->with('success', 'Gebruiker toegevoegd aan rol.');

        Log::info("Assign role called with:", $request->all());
    }

    public function removeFromRole(Request $request)
    {
        try {
            $user = User::findOrFail($request->user_id);
            $role = Role::findOrFail($request->role_id);

            if (!$user->roles()->where('role_id', $role->id)->exists()) {
                return response()->json(['error' => 'Gebruiker heeft deze rol niet.'], 409);
            }

            $user->roles()->detach($role);
            return response()->json(['success' => 'Gebruiker succesvol verwijderd uit de rol.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Serverfout: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
