<?php

namespace App\Http\Controllers;

use App\Models\DataJadwal as ModelDataJadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DataJadwal extends Controller
{
    public function index()
    {
        $data = ModelDataJadwal::all();
        return view('data_jadwal.index', ['data' => $data]);
    }

    public function tambah()
    {
        return view('data_jadwal.tambah');
    }

    public function edit($id)
    {
        $data = ModelDataJadwal::find($id);
        return view('data_jadwal.edit', ['data' => $data]);
    }

    public function hapus(Request $request)
    {
        ModelDataJadwal::where('id', $request->id)->delete();
        Session::flash('success', 'Berhasil Hapus Data');
        return redirect('/datajadwal');
    }

    public function create(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date',
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'lokasi.required' => 'Lokasi wajib diisi.',
            'waktu_mulai.required' => 'Waktu mulai wajib diisi.',
            'waktu_selesai.required' => 'Waktu selesai wajib diisi.',
        ]);

        ModelDataJadwal::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
        ]);

        Session::flash('success', 'Data berhasil ditambahkan');
        return redirect('/datajadwal');
    }

    public function change(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date',
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'lokasi.required' => 'Lokasi wajib diisi.',
            'waktu_mulai.required' => 'Waktu mulai wajib diisi.',
            'waktu_selesai.required' => 'Waktu selesai wajib diisi.',
        ]);

        $datajadwal = ModelDataJadwal::find($request->id);
        $datajadwal->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
        ]);

        Session::flash('success', 'Berhasil Mengubah Data');
        return redirect('/datajadwal');
    }

    // Method untuk melakukan pencarian data
    public function search(Request $request)
    {
        // Ambil keyword dari input form
        $keyword = $request->input('keyword');

        // Cari data berdasarkan keyword
        $data = ModelDataJadwal::where('judul', 'like', "%$keyword%")
                        ->orWhere('deskripsi', 'like', "%$keyword%")
                        ->orWhere('lokasi', 'like', "%$keyword%")
                        ->get();

        // Tampilkan hasil pencarian
        return view('data_jadwal.hasil', compact('data'));
    }

    // Method untuk melakukan filter data berdasarkan tanggal
    public function filter(Request $request)
    {
        // Ambil tanggal dari input form
        $date = $request->input('date');

        // Filter data berdasarkan tanggal
        $data = ModelDataJadwal::whereDate('waktu_mulai', $date)->get();

        // Tampilkan hasil filter
        return view('data_jadwal.hasil', compact('data'));
    }

    
}
