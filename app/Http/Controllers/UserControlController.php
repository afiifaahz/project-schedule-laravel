<?php

namespace App\Http\Controllers;

use App\Mail\AuthMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserControlController extends Controller
{
    function index()
    {
        $data = User::all();
        return view('user_control.index', ['uc' => $data]);
    }

    function tambah()
    {
        return view('user_control.tambah');
    }
    function create(Request $request)
    {
        $str = Str::random(100);

        $request->validate([
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'name.required' => 'Full Name Wajib Di isi',
            'name.min' => 'Bidang Full Name minimal harus 4 karakter.',
            'email.required' => 'Email Wajib Di isi',
            'email.email' => 'Format Email Invalid',
            'password.required' => 'Password Wajib Di isi',
            'password.min' => 'Password minimal harus 6 karakter.',
        ]);



        $accounts = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'verify_key' => $str,
        ]);

        $details = [
            'nama' => $accounts->name,
            'role' => 'user',
            'datetime' => date('Y-m-d H:i:s'),
            'website' => 'Laravel10 - Pendaftaran melalui SMTP + Multiuser + CRUD + Sweetalert',
            'url' => 'http://' . request()->getHttpHost() . "/" . "verify/" . $accounts->verify_key,
        ];

        Mail::to($request->email)->send(new AuthMail($details));

        Session::flash('success', 'User berhasil ditambahkan , Harap verifikasi akun sebelum di gunakan.');

        return redirect('/usercontrol');
    }

    function edit($id)
    {
        $data = User::where('id', $id)->get();
        return view('user_control.edit', ['uc' => $data]);
    }
    function change(Request $request)
    {
        $request->validate([
            'name' => 'required|min:4',
        ], [

            'name.required' => 'Nama Wajib Di isi',
            'name.min' => 'Bidang nama minimal harus 4 karakter.',
        ]);



        $user = User::find($request->id);

       

        $user->name = $request->name;
        $user->password = $request->password;
        $user->save();

        Session::flash('success', 'User berhasil diedit');

        return redirect('/usercontrol');
    }
    function hapus(Request $request)
    {
        User::where('id', $request->id)->delete();

        Session::flash('success', 'Data berhasil dihapus');

        return redirect('/usercontrol');
    }
}
