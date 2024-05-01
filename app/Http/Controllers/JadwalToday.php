<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DataJadwal;
use Illuminate\Support\Facades\Auth;


class JadwalToday extends Controller
{
    public function showJadwal()
    {
        // Mengambil jadwal yang akan dimulai hari ini
        $schedules = DataJadwal::whereDate('waktu_mulai', Carbon::today())->get();
    
        // Kirim data jadwal ke view
        return view('notif', compact('schedules'));
    }
}


