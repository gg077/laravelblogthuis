<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{

    protected $folder='users';
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
            'photo_id'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], $messages);

        //paswoord hashen
        $validatedData['password'] = hash::make($validatedData['password']);

        // controlleeer of er photo is geupload en sla deze op
        if ($request->hasFile('photo_id')) {
            $file = $request->file('photo_id');
            $uniqueName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $filePath = $this->folder . '/' . $uniqueName;

            // opslaan in het public path onder users
            $file->storeAs('', $filePath, 'public');
            $photo = Photo::create([
                'path' => $filePath,
                'alternate_text' => $validatedData['name']
            ]);
            $validatedData['photo_id'] = $photo->id;
        }

        //gebruiker aanmaken
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'is_active' => $validatedData['is_active'],
            'password' => $validatedData['password'],
            'photo_id' => $validatedData['photo_id'],
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
    public function edit($id)
    {
        $user = User::with('roles', 'photo')->findOrFail($id);
        $roles = Role::pluck('name', 'id')->all();
        $photoDetails = ['exists' => false, 'filesize' => 0, 'width' => 'N/A', 'height' => 'N/A', 'extension' => ''];
        // Controleer of er een foto is en of deze bestaat op de 'public' disk
        if ($user->photo && Storage::disk('public')->exists($user->photo->path)) {
            $photoDetails['exists'] = true;
            $photoDetails['filesize'] = round(Storage::disk('public')->size($user->photo->path) / 1024, 2);
            $photoPath = Storage::disk('public')->path($user->photo->path);
            $dimensions = getimagesize($photoPath);
            $photoDetails['width'] = $dimensions[0] ?? 'N/A';
            $photoDetails['height'] = $dimensions[1] ?? 'N/A';
            $photoDetails['extension'] = Str::upper(pathinfo($user->photo->path, PATHINFO_EXTENSION));
        }
        return view('backend.users.edit', compact('user', 'roles', 'photoDetails'));
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
