@extends('dashboard.index')

@section('navitem')
                        <li><a href="/user" class="active"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>        
						<li><a href="notifications.html" class=""><i class="lnr lnr-alarm"></i> <span>Notifications</span></a></li>
						<li>
							<a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Pages</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages" class="collapse ">
								<ul class="nav">
                                    <li><a href="{{ route('usercontrol') }}" class="">User Control</a></li>
									
								</ul>
								<ul class="nav">
                                    <li><a href="{{ route('datajadwal') }}" class="">Data Jadwal</a></li>
									
								</ul>
							</div>
						</li>
						

@endsection

@section('main')
	<!-- MAIN -->
	<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Dashboard <b>{{ Auth::user()->name}}</b></h3>
							<p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3">
									<div class="metric">
										<span class="icon"><i class="fa fa-download"></i></span>
										<p>
											<span class="number">{{ Auth::user()->role }}</span>
											<span class="title">{{ Auth::user()->email }}</span>
										</p>
									</div>
								</div>
								
							</div>
							<div class="row">
								<div class="col-md-9">
									<div id="headline-chart" class="ct-chart"></div>
								</div>
								
							</div>
						</div>
					</div>
					<!-- END OVERVIEW -->
					<div class="row">
						
					</div>
					
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
@endsection