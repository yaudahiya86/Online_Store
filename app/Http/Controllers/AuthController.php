<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function register()
    {
        return view('register');
    }
    public function loginsubmit(Request $request)
    {
        Session::flash('email', $request->email);
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email harus di isi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus di isi'
        ]);
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (Auth::attempt($data)) {
            $user = Auth::user();
            // dd($user->nama_lengkap);
            if ($user->id_role == 1) {
                return redirect()->route('dashboard')->with('success', 'Selamat datang! Anda login sebagai admin');
            } elseif ($user->id_role == 2) {
                return redirect()->route('beranda');
            } else {
                // Jika id_role tidak dikenali
                Auth::logout();
                return redirect('/')->with('loginError', 'Hak akses tidak valid.');
            }
        } else {
            return redirect('/')->with('loginError', 'Gagal login. Periksa kembali email dan password Anda.');
        }
    }
    public function registersubmit(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telephone' => 'required|string|max:15|unique:users',
            'password' => 'required|string|min:6|confirmed', // Validasi confirmed
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Simpan data ke database
        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'foto' => 'deafultpp.svg',
            'id_role' => 2,
            'password' => Hash::make($request->password),
        ]);

        // Redirect ke halaman login atau dashboard
        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }
    public function logout(Request $request)
    {
        // Logout user
        Auth::logout();

        // Invalidasi sesi pengguna
        $request->session()->invalidate();

        // Regenerasi token CSRF untuk keamanan
        $request->session()->regenerateToken();

        // Redirect ke halaman login atau halaman lain
        return redirect('/')->with('success', 'Anda Berhasil Log Out.');
    }

    public function logoutuser()
    {
        // Logout user
        Auth::logout();

        // Invalidasi sesi pengguna
        session()->invalidate();

        // Regenerasi token CSRF untuk keamanan
        session()->regenerateToken();

        // Redirect ke halaman login atau halaman lain
        return redirect('/')->with('success', 'Anda berhasil log out.');
    }
}
