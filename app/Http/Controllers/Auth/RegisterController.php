<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
;
class RegisterController extends Controller
{
    //Halaman Registasi
    public function showRegister()
    {
        return view('auth.register');
    }

    //Proses registrasi,
    public function register(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'alamat'    => 'required|string|max:255',
            'telepon'   => 'nullable|string|max:20',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8|confirmed',
            'terms'     => 'accepted',
        ]); 

        $user = User::create([
            'nama'     => $request->nama,
            'alamat'   => $request->alamat, 
            'telepon'  => $request->phone,
            'email'    => $request->email,
            'role'     => 'member',
            'password' => Hash::make($request->password),
        ]);
   
        Auth::login($user);

        return redirect()->route('member.dashboard')
            ->with('status', 'Selamat, akun Anda telah aktif!');
    }
}
