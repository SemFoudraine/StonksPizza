<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->q;
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->get();
        return response()->json($users);
    }

    public function addToRole(Request $request)
    {
        $user = User::find($request->user_id);
        $role = Role::find($request->role_id);

        if (!$user || !$role) {
            return response()->json(['error' => 'Gebruiker of rol niet gevonden.'], 404);
        }

        // Controleer of de gebruiker de rol al heeft
        if ($user->roles()->where('role_id', $role->id)->exists()) {
            return response()->json(['error' => 'Gebruiker heeft deze rol al.'], 409);
        }

        // Voeg de rol toe als deze nog niet bestaat
        $user->roles()->attach($role);
        return response()->json(['success' => 'Gebruiker succesvol toegevoegd aan de rol.']);
    }
}
