<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="icon" href="{{ asset("assets/images/favicon.png") }}" type="image/x-icon" />
		<link rel="shortcut icon" href="{{ asset("assets/images/favicon.png") }}" type="image/x-icon" />
		<title>Error 500</title>
		<link
			href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap"
			rel="stylesheet"
		/>
		<link
			href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
			rel="stylesheet"
		/>
		<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/fontawesome.css") }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/vendors/icofont.css") }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/vendors/themify.css") }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/vendors/flag-icon.css") }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/vendors/feather-icon.css") }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/vendors/bootstrap.css") }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/style.css") }}" />
		<link id="color" rel="stylesheet" href="{{ asset("assets/css/color-1.css") }}" media="screen" />
		<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/responsive.css") }}" />
	</head>
	<body>
		<div class="tap-top"><i data-feather="chevrons-up"></i></div>
		<div class="page-wrapper compact-wrapper" id="pageWrapper">
			<div class="error-wrapper">
				<div class="container">
					<svg>
						<use href="{{ asset("assets/svg/icon-sprite.svg") }}#error-500"></use>
					</svg>
					<div class="col-md-8 offset-md-2">
						<h3>Server Error</h3>
						<p class="sub-content">The server couldn't finish processing your request due to an error.</p>
					</div>
					<div><a class="btn btn-primary btn-lg" href="{{ route("home") }}">BACK TO HOME PAGE</a></div>
				</div>
			</div>
		</div>
		<script src="{{ asset("assets/js/jquery.min.js") }}"></script>
		<script src="{{ asset("assets/js/bootstrap/bootstrap.bundle.min.js") }}"></script>
		<script src="{{ asset("assets/js/icons/feather-icon/feather.min.js") }}"></script>
		<script src="{{ asset("assets/js/icons/feather-icon/feather-icon.js") }}"></script>
		<script src="{{ asset("assets/js/config.js") }}"></script>
		<script src="{{ asset("assets/js/script.js") }}"></script>
		<script src="{{ asset("assets/js/script1.js") }}"></script>
	</body>
</html>
