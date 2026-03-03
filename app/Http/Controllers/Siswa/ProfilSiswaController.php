<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ProfilSiswaController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->siswa) {
            abort(403, 'Data siswa tidak ditemukan');
        }

        return view('siswa.profil', [
            'siswa' => $user->siswa
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', true);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}