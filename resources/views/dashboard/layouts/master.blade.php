<!DOCTYPE html>

<html lang="en" >

	<head>
		<link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css') }}">
		@include('dashboard.common.head')

	</head>

	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >

		<div class="m-grid m-grid--hor m-grid--root m-page">

			@include('dashboard.common.header')
			<!-- begin::Body -->
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
				@include('dashboard.common.nav')

				@yield('content')
			</div>
			<!-- end:: Body -->

			@include('dashboard.common.footer')

			@include('dashboard.common.quick-sidebar')

			<!-- begin::Scroll Top -->
			<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
				<i class="la la-arrow-up"></i>
			</div>
			<!-- end::Scroll Top -->

			@include('dashboard.common.quick-nav')

			<script src="{{ asset('assets/vendors/jquery/dist/jquery.min.js') }}"></script>
			<script src="{{ asset('assets/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
			<!--begin::Base Scripts -->
			<script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/demo/demo3/base/scripts.bundle.js') }}" type="text/javascript"></script>
			<!--end::Base Scripts -->
	        <!--begin::Page Vendors -->
			<script src="{{ asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript"></script>
			<!--end::Page Vendors -->

	        <!--begin::Page Snippets -->
			<script src="{{ asset('assets/app/js/dashboard.js') }}" type="text/javascript"></script>
			<!--end::Page Snippets -->
			@stack('scripts')
		</div>
	</body>

</html>
