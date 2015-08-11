@if(Session::has('toasts'))
	<!-- Messenger http://github.hubspot.com/messenger/ -->
	<script src="{{ asset('/bower_components/admin-lte/plugins/toast/jquery.min.js') }}"></script>
	<script src="{{ asset('/bower_components/admin-lte/plugins/toast/toastr.min.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('/bower_components/admin-lte/plugins/toast/toastr.min.css') }}">

	<script type="text/javascript">
		toastr.options = {
			"closeButton": true,
			"newestOnTop": true,
			"positionClass": "toast-top-center"
		};

		@foreach(Session::get('toasts') as $toast)
			toastr["{{ $toast['level'] }}"]("{{ $toast['message'] }}","{{ $toast['title'] }}");
		@endforeach
	</script>
@endif
