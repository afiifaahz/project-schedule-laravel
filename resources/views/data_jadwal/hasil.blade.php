@extends('dashboard.index')

@if(Auth::user()->role === 'admin')
    @section('navitem')
        <li><a href="/admin" class="active"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>        

        <li><a href="notifications.html" class=""><i class="lnr lnr-alarm"></i> <span>Notifications</span></a></li>
        <li>
            <a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Pages</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
            <div id="subPages" class="collapse ">
                <ul class="nav">
                    <li><a href="{{ route('usercontrol') }}" class="">User Control</a></li>
                    
                </ul>
            </div>
        </li>
        
    @endsection
@elseif(Auth::user()->role === 'user')
    @section('navitem')
        <li><a href="/user" class="active"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>        

        <li><a href="/notications" class=""><i class="lnr lnr-alarm"></i> <span>Notifications</span></a></li>
        <li>
            <a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Pages</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
            <div id="subPages" class="collapse ">
                <ul class="nav">
                    <li><a href="{{ route('datajadwal') }}" class="">Data Jadwal</a></li>
                
                </ul>
            </div>
        </li>
    
    @endsection
@endif

@section('main')
    <!-- MAIN -->
    <div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <h3 class="page-title"><b>Tables</b></h3>
            <a href="/dajatambah" class="btn-sm btn-primary text-decoration-none">Tambah data</a><br>
            <br>
            <!-- Form Pencarian -->
            <form action="/search" method="GET" class="form-inline mt-3">
                <div class="form-group mr-2">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari berdasarkan judul, waktu, atau lokasi">
                </div>
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>

            <!-- Form Filter -->
            <form action="/filter" method="GET" class="form-inline mt-3">
                <div class="form-group mr-2">
                    <input type="date" name="date" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>

            <!-- Penanganan Error dan Pesan Sukses -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (Session::has('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire(
                            'Sukses',
                            '{{ Session::get('success') }}',
                            'success'
                        );
                    });
                </script>
            @endif
            <br><br>
            <div class="row">
                <div class="col-md-12">
                    <!-- BASIC TABLE -->
                    <div class="panel">
                        <div class="panel-heading">
                            <br>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                @if(isset($data) && $data->count() > 0)
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="col-md-2">Judul</th>
                                                <th class="col-md-3">Deskripsi Kegiatan</th>
                                                <th class="col-md-2">Lokasi</th>
                                                <th class="col-md-2">Waktu Mulai</th>
                                                <th class="col-md-2">Waktu Selesai</th>
                                                <th class="col-md-1">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td>{{ $item->judul }}</td>
                                                    <td>{{ $item->deskripsi }}</td>
                                                    <td>{{ $item->lokasi }}</td>
                                                    <td>{{ $item->waktu_mulai }}</td>
                                                    <td>{{ $item->waktu_selesai }}</td>
                                                    <td>
                                                        <a href="/dajaedit/{{ $item->id }}" class="btn-sm btn-warning text-decoration-none">Edit</a> | 
                                                        <form onsubmit="confirmHapus(event)" action="/dajahapus/{{ $item->id }}" method="get" class="d-inline">
                                                            @csrf 
                                                            <button type="submit" class="btn-sm btn-danger">Hapus</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p>Tidak ada hasil pencarian</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- END BASIC TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->
<div class="clearfix"></div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function confirmHapus(event) {
        event.preventDefault(); // Menghentikan form dari pengiriman langsung

        Swal.fire({
            title: 'Yakin Hapus Data?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((willDelete) => {
            if (willDelete.isConfirmed) {
                event.target.submit(); // Melanjutkan pengiriman form
            } else {
                swal('Your imaginary file is safe!');
            }
        });
    }
</script>
