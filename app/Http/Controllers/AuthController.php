<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // Import namespace Auth yang benar
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\AuthMail;


class AuthController extends Controller
{
    // function index(){
    //     return view('login');
    // }

    function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ],[
            'email.required' => 'Email wajib diisi',
            'password.required' => 'password wajib diisi',
        ]);
    
        //simpan ke db
        $infoLogin = [
            'email' => $request->email,
            'password' => $request->password,
        ];
    
        //cek apakah ada di db
        if(Auth::attempt($infoLogin)){
            //jika email sudah dikonfir
            if(Auth::user()->email_verified_at != null){
                if(Auth::user()->role === 'admin'){
                    // Simpan informasi pengguna dalam sesi
                    $request->session()->put('user', Auth::user());
                    return redirect()->route('admin')->with('success', 'Halo Admin, Anda berhasil login');
                }else if(Auth::user()->role === 'user'){
                    // Simpan informasi pengguna dalam sesi
                    $request->session()->put('user', Auth::user());
                    return redirect()->route('user')->with('success', 'Berhasil login');
                }
            }else{
                Auth::logout();
                return redirect()->route('login')->withErrors('Akun anda belum aktif. Harap Verifikasi terlebih dahulu');
            }
        }else{
            return redirect()->route('login')->withErrors("Email atau password salah");
        }

    }

    function create()
    {

    }

    function daftar(Request $request)
    {
        $str = Str::random(100);
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:5',
        ],[
            'name.required'=> 'Nama wajib diisi',
            'name.min'=> 'Nama minimal 5 karakter',
            'email.required'=> 'Email wajib diisi',
            'email.unique'=> 'Email telah terdaftar',
            'password.required'=> 'Password wajib diisi',
            'password.min'=> 'Password minimal 5 karakter',
        ]);

        $infodaftar = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'verify_key'=> $str,
        ];

        User::create($infodaftar);

        $details = [
            'nama'=>$infodaftar['name'],
            'role'=>'user',
            'datetime'=>date ('Y-m-d H:i:s'),
            'website'=>'Project Laravel Sistem Penjadwalan',
            'url'=>'http://' .request()->getHttpHost()."/"."verify/". $infodaftar['verify_key'],
        ];

        Mail::to($infodaftar['email'])->send(new AuthMail($details));

        return redirect()->route('login')->with('Success', 'Link verifikasi telah dikirim ke email anda. Cek email anda untuk melakukan verifikasi');
    }

    function verify($verify_key){
        $keyCheck = User::select('verify_key')
        ->where('verify_key', $verify_key)
        ->exists();

        if($keyCheck){
            $user = User::where('verify_key', $verify_key)->update(['email_verified_at' => date('Y-m-d H:i:s')]);
            return redirect()->route('login')->with('succes','verifikasi email berhasil, akun anda sudah aktif');
        }else{
            return redirect()->route('login')->withErrors('Keys tidak valid. pastikan telah melakukan register')->withInput();
        }
    }

    function logout(){
        Auth::logout();
        return redirect('/');
    }
    

    // public function register(Request $request)
    // {
    //     // Validasi data yang diterima dari formulir
    //     $request->validate([
    //         'nama' => 'required',
    //         'password' => 'required',
    //     ]);

    //     // Simpan data ke dalam database
    //     $user = new User();
    //     $user->nama = $request->nama;
    //     $user->password = bcrypt($request->password);
    //     $user->save();

    //     // Redirect ke halaman tertentu setelah data disimpan
    //     return redirect('/login');
    // }

    // public function login(Request $request)
    // {
    //     $credentials = $request->only('nama', 'password');

    //     if (Auth::attempt($credentials)) {
    //         // Jika autentikasi berhasil, redirect ke halaman yang sesuai
    //         return redirect()->intended('home');
    //     }

    //     // Jika autentikasi gagal, kembali ke halaman login dengan pesan kesalahan
    //     return redirect('/login')->with('error', 'Nama atau password salah');
    // }
}
?>