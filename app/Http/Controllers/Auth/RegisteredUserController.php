<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'min:3', 'max:50'],
            'nama' => ['required', 'string', 'min:3', 'max:50'],
            'nomor_induk' => ['required', 'string', 'min:10', 'max:20', 'unique:' . UserModel::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:50', 'unique:' . UserModel::class],
            'password' => ['required', Rules\Password::defaults()],
            'foto_profile' => ['required', 'image', 'max:2048', 'mimes:jpeg,jpg,png'],
            'identitas' => ['required', 'image', 'max:2048', 'mimes:jpeg,jpg,png,pdf'],
        ]);

        $fotoProfilePath = $request->file('foto_profile')->store('foto_profile', 'public');
        $identitasPath = $request->file('identitas')->store('identitas', 'public');

        // Ambil hanya nama filenya saja, tanpa folder
        $fotoProfileName = basename($fotoProfilePath);
        $identitasName = basename($identitasPath);

        $user = UserModel::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nama' => $request->nama,
            'nomor_induk' => $request->nomor_induk,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'Tidak Aktif',
            'foto_profile' => $fotoProfileName,  // hanya nama file
            'identitas' => $identitasName,       // hanya nama file
            'created_at' => now(),
        ]);

        event(new Registered($user));

        // Hanya login jika status user adalah "Aktif"
        if ($user->status === 'Aktif') {
            Auth::login($user);
            return redirect(RouteServiceProvider::HOME);
        }

        // Jika belum aktif, arahkan ke halaman info (buatkan view khusus jika perlu)
        return redirect()->route('waiting')->with('status', 'Akun Anda berhasil didaftarkan. Silakan tunggu verifikasi dari admin.');
    }
}
