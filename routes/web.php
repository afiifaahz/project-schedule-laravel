<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DataJadwal;
use App\Http\Controllers\UserControlController;
use App\Http\Controllers\UproleController;
use App\Http\Controllers\JadwalToday;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware(['guest'])->group(function(){
    Route::get('/', function() {
        return view('login');
    })->name('login');
    Route::post('/', [AuthController::class, 'login'])->name('login'); // Panggil metode login dari AuthController

    
    Route::get('/daftar', function () {
        return view('daftar');
    })->name('daftar');
    Route::post('/daftar', [AuthController::class, 'daftar'])->name('daftar'); // Panggil metode daftar dari AuthController
    
    Route::get('/verify/{verify_key}', [AuthController::class, 'verify']);
    

});


Route::middleware(['auth'])->group(function(){
    Route::redirect('/home','/user');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin')-> middleware('userAkses:admin');
    Route::get('/user', [UserController::class, 'index'])->name('user')-> middleware('userAkses:user');

    Route::get('/datajadwal',[DataJadwal::class, 'index'])->name('datajadwal');
    Route::get('/dajatambah', [DataJadwal::class,'tambah']); 
    Route::get('/dajaedit/{id}', [DataJadwal::class,'edit']); 
    Route::get('/dajahapus/{id}', [DataJadwal::class,'hapus']); 

    Route::get('/usercontrol',[UserControlController::class, 'index'])->name('usercontrol');

    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

    Route::post('/tambahdaja', [DataJadwal::class, 'create']);
    Route::post('/editdaja', [DataJadwal::class, 'change']);

    Route::get('/tambahuc', [UserControlController::class, 'tambah']);
    Route::get('/edituc/{id}', [UserControlController::class, 'edit']);
    Route::post('/hapusuc/{id}', [UserControlController::class, 'hapus']);
    Route::post('/tambahuc', [UserControlController::class, 'create']);
    Route::post('/edituc', [UserControlController::class, 'change']);
    Route::get('/search', [DataJadwal::class, 'search'])->name('search');
    Route::get('/filter', [DataJadwal::class, 'filter'])->name('filter');
    Route::post('/uprole/{id}', [UproleController::class, 'index']);
    Route::get('/notifications', [JadwalToday::class, 'showJadwal']);
});
