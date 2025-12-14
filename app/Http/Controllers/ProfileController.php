<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit'); // optional, kalau mau halaman terpisah
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,'.auth()->id(),
            'language_preference' => 'nullable|in:id,en',
            'current_password'    => 'nullable|required_with:password|current_password',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('language_preference')) {
            $user->language_preference = $request->language_preference;
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui!',
            'profile_photo_url' => $user->profile_photo_url
        ]);
    }

    // Update Foto Profil (AJAX)
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();

        // Hapus foto lama kalau bukan default
        if ($user->profile_photo_path && $user->profile_photo_path !== 'profile-photos/default.jpg') {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $path = $request->file('profile_photo')->store('profile-photos', 'public');

        $user->profile_photo_path = $path;
        $user->save();

        return response()->json([
            'success' => true,
            'profile_photo_url' => $user->profile_photo_url . '?' . time() // biar langsung refresh cache
        ]);
    }
}