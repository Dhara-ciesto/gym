@extends('layout.emp_mainlayout')

@section('title', 'Dashboard')

@section('content')
	<section class="content-header">
		<h1>
			Dashboard
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Dashboard</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-yellow">
					<div class="inner">
						<p>Today Log</p>
					</div>
					<div class="icon">
						<i class="ion ion-person-add"></i>
					</div>
					<div>
						<span>Check In : </span>
						<span>
							
						@if(!empty($min))
							{{ $min }}
						@endif
						</span>
					</div>

					<div>
						<span>Check Out : </span>
						@if(!empty($max))
							{{ $max }}
						@endif
					</div>
					</i></a>
				</div>
			</div>


		</div>
	</section>

@endsection