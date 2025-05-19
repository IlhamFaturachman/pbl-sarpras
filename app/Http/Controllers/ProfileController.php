<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.index', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        $request->validate([
            'nomor_induk' => 'required|string|max:255',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:m_user,email,'.$user->user_id.',user_id',
            'nama' => 'required|string|max:255|unique:m_user,nama,'.$user->user_id.',user_id',
            'password' => 'nullable|string|min:8',
        ]);

        // Update user fields
        $user->nomor_induk = $request->nomor_induk;
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->nama = $request->nama;

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    // Method baru khusus untuk update foto profil
    public function updatePhoto(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        $request->validate([
            'foto_profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('foto_profile')) {
            // Delete old file if exists
            if ($user->foto_profile && Storage::exists('public/'.$user->foto_profile)) {
                Storage::delete('public/'.$user->foto_profile);
            }
            
            $path = $request->file('foto_profile')->store('profile_photos', 'public');
            $user->foto_profile = $path;
            $user->save();
        }

        return Redirect::route('profile.edit')->with('success', 'Foto profil berhasil diperbarui!');
    }
}