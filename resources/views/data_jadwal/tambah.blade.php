@extends('dashboard.index')
@section('navitem')
                        <li><a href="/user" class="active"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>        
                        <li><a href="/notifications" class=""><i class="lnr lnr-alarm"></i> <span>Notifications</span></a></li>
						<li>
							<a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Pages</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages" class="collapse ">
								<ul class="nav">
                                    <li><a href="{{ route('datajadwal') }}" class="">Data Jadwal</a></li>
									
								</ul>
							</div>
						</li>
						

@endsection
@section('main')
<div class="main">
<div class="main-content">
    <div class="container-fluid">
        <!-- <div class="row justify-content-center">
            <div class="col-lg-6"> -->
            <div class="panel panel-headline">
            <div class="panel-body">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Tambah data jadwal</h4>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="forms-sample" method="POST" action="/tambahdaja" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="judul" placeholder="Judul" name="judul" required>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <input type="text" class="form-control" id="deskripsi" placeholder="Deskripsi" name="deskripsi" required>
                            </div>
                            <div class="mb-3">
                                <label for="lokasi" class="form-label">Lokasi</label>
                                <input type="text" class="form-control" id="lokasi" placeholder="Lokasi" name="lokasi" required>
                            </div>
                            <div class="mb-3">
                                <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                <input type="datetime-local" class="form-control" id="waktu_mulai" name="waktu_mulai" required>
                            </div>
                            <div class="mb-3">
                                <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                                <input type="datetime-local" class="form-control" id="waktu_selesai" name="waktu_selesai" required>
                            </div><br>
                            <button type="submit" class="btn btn-primary me-2">Tambah</button>
                            <a href="/datajadwal" class="btn btn-light">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div></div>


    <div class="clearfix"></div>
@endsection

