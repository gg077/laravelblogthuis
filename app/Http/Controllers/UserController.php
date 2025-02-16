<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        //de homepagina van mijn users
        $users = User::with('roles')->get();

        //return view('backend.users.index',['users' => $users, 'roles' => $roles]);
        return view('backend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name','id')->all();
        return view('backend.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //
        $messages = [
            'name.required' => 'De naam is verplicht.',
            'email.required' => 'Het e-mailadres is verplicht.',
            'email.email' => 'Voer een geldig e-mailadres in.',
            'email.unique' => 'Dit e-mailadres is al in gebruik.',
            'password.required' => 'Het wachtwoord is verplicht.',
            'password.min' => 'Het wachtwoord moet minimaal :min tekens bevatten.',
            'role_id.required' => 'Selecteer minimaal 1 rol voor de gebruiker.',
            'role_id.*.exists' => '1 van de geslecteerde rollen bestaat niet.',
            'role_id.array'=>'De rollen moeten een lijst van ID\'s zijn.',
            'is_active.required' => 'Selecteer of de gebruiker actief is.',
            'photo_id.image' => 'De geüploade afbeelding moet een geldig afbeeldingsbestand zijn.',];

        //wegschrijven van de nieuwe user
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'is_active' => 'required|in:0,1',
            'role_id'=>'required|array|exists:roles,id',
            'password' => 'required|min:6',
//           'photo_id'=>'nullable|image'
        ], $messages);

        //paswoord hashen
        $validatedData['password'] = bcrypt($validatedData['password']);

        //gebruiker aanmaken
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'is_active' => $validatedData['is_active'],
            'password' => $validatedData['password'],
        ]);
        //array van rollen wegschrijven naar de role_user tussentabel
        //sync doet een detach en daarna een attach in 1 keer
        $user->roles()->sync($validatedData['role_id']);

        //redirect naar users
        return redirect()->route('users.index')->with('message', 'User created successfully!');
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
