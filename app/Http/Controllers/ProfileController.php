<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        // Upload da nova foto de perfil, se fornecida
        if ($request->hasFile('profile_photo')) {
            // Excluir a foto antiga, se existir
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $imagePath = $request->file('profile_photo')->store('profile-photos', 'public');
            $data['profile_photo_path'] = $imagePath;
        }

        $user->update($data);

        return redirect()->route('profile.edit')->with('success', 'Perfil atualizado com sucesso!');
    }
}