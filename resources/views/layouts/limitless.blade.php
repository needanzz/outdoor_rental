<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Outdoor Rental Admin</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('limitless/global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    
    <link href="{{ asset('limitless/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('limitless/assets/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('limitless/assets/css/layout.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('limitless/assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('limitless/assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('limitless/global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ asset('limitless/global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('limitless/global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
    
    <script src="{{ asset('limitless/assets/js/app.js') }}"></script>
    @yield('styles')
</head>

<body>

	@include('layouts.partials.navbar')
	<div class="page-content">

		@include('layouts.partials.sidebar')
		<div class="content-wrapper">

			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
                        {{-- Judul akan berubah sesuai @section('title') di tiap halaman --}}
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">@yield('title', 'Dashboard')</span></h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>

                {{-- Breadcrumb --}}
				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="{{ route('home') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
							<span class="breadcrumb-item active">@yield('title')</span>
						</div>
					</div>
				</div>
			</div>
			<div class="content">

                {{-- Alert Flash Message --}}
                @if(session('success'))
                    <div class="alert alert-success border-0 alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        <span class="font-weight-semibold">Berhasil!</span> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger border-0 alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        <span class="font-weight-semibold">Error!</span> {{ session('error') }}
                    </div>
                @endif

				@yield('content')

			</div>
			<div class="navbar navbar-expand-lg navbar-light">
				<div class="text-center d-lg-none w-100">
					<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
						<i class="icon-unfold mr-2"></i>
						Footer
					</button>
				</div>

				<div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text">
						&copy; 2026. <a href="#">Outdoor Rental System</a> by <a href="#" target="_blank">Muhammad Danil</a>
					</span>
				</div>
			</div>
			</div>
		</div>
    @yield('scripts')

</body>
</html>