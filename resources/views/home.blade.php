@extends("layouts")

@section("styles")
	<link href="{{ asset("assets/css/vendors/select2.css") }}" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/vendors/flatpickr/flatpickr.min.css") }}" />
@endsection

@section("title", "Home")

@section("content")
	
@endsection

@section("scripts")
	<script src="{{ asset("assets/js/select2/select2.full.min.js") }}"></script>
	<script src="{{ asset("assets/js/flat-pickr/flatpickr.js") }}"></script>
@endsection
