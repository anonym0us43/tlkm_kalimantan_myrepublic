<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/vendors/sweetalert2.css") }}" />
<script src="{{ asset("assets/js/sweet-alert/sweetalert.min.js") }}"></script>
<style>
	.swal2-popup.swal2-toast .swal2-title {
		font-size: 0.85rem !important;
		font-family:
			'TelkomselBatikSans',
			-apple-system,
			sans-serif !important;
		font-weight: 600 !important;
	}

	.swal2-popup.swal2-toast {
		border-radius: 8px !important;
		box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12) !important;
	}

	.swal2-popup.swal2-toast .swal2-timer-progress-bar {
		background: rgba(26, 39, 68, 0.25) !important;
	}
</style>

@php
 $errorMsg = "";
 if ($errors->any()) {
 	$errorMsg = collect($errors->all())->implode(" ");
 }
@endphp

@if (session("success") || session("error") || session("info") || session("warning") || ! empty($errorMsg))
	<script>
		document.addEventListener('DOMContentLoaded', function() {
  	@if (session('success'))
  		Swal.fire({
  			toast: true,
  			position: 'top-end',
  			icon: 'success',
  			title: @json(session('success')),
  			showConfirmButton: false,
  			timer: 3000,
  			timerProgressBar: true
  		});
  	@elseif (session('error'))
  		Swal.fire({
  			toast: true,
  			position: 'top-end',
  			icon: 'error',
  			title: @json(session('error')),
  			showConfirmButton: false,
  			timer: 3000,
  			timerProgressBar: true
  		});
  	@elseif (session('info'))
  		Swal.fire({
  			toast: true,
  			position: 'top-end',
  			icon: 'info',
  			title: @json(session('info')),
  			showConfirmButton: false,
  			timer: 3000,
  			timerProgressBar: true
  		});
  	@elseif (session('warning'))
  		Swal.fire({
  			toast: true,
  			position: 'top-end',
  			icon: 'warning',
  			title: @json(session('warning')),
  			showConfirmButton: false,
  			timer: 3000,
  			timerProgressBar: true
  		});
  	@endif
  	@if (!empty($errorMsg))
  		Swal.fire({
  			toast: true,
  			position: 'top-end',
  			icon: 'error',
  			title: @json($errorMsg),
  			showConfirmButton: false,
  			timer: 4000,
  			timerProgressBar: true
  		});
  	@endif
  });
	</script>
@endif
