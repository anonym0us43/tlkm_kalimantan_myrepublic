<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<link rel="icon" href="{{ asset("assets/images/favicon.png") }}" type="image/x-icon" />
		<link rel="shortcut icon" href="{{ asset("assets/images/favicon.png") }}" type="image/x-icon" />
		<title>@yield("title", "Home") — MyRepublic</title>
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
		<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/vendors/scrollbar.css") }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/vendors/animate.css") }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/vendors/bootstrap.css") }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/style.css") }}" />
		<link id="color" rel="stylesheet" href="{{ asset("assets/css/color-1.css") }}" media="screen" />
		<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/responsive.css") }}" />
		@yield("styles")
	</head>
	<body onload="startTime()">
		<div class="loader-wrapper">
			<div class="loader-index"><span></span></div>
			<svg>
				<defs></defs>
				<filter id="goo">
					<fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
					<fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"></fecolormatrix>
				</filter>
			</svg>
		</div>
		<div class="tap-top"><i data-feather="chevrons-up"></i></div>
		<div class="page-wrapper compact-wrapper" id="pageWrapper">
			<div class="page-header">
				<div class="header-wrapper row m-0">
					<form class="form-inline search-full col" action="#" method="get">
						<div class="form-group w-100">
							<div class="Typeahead Typeahead--twitterUsers">
								<div class="u-posRelative">
									<input
										class="demo-input Typeahead-input form-control-plaintext w-100"
										type="text"
										placeholder="Search Anything Here..."
										name="q"
										title=""
										autofocus
									/>
									<div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">Loading...</span></div>
									<i class="close-search" data-feather="x"></i>
								</div>
								<div class="Typeahead-menu"></div>
							</div>
						</div>
					</form>
					<div class="header-logo-wrapper col-auto p-0">
						<div class="logo-wrapper">
							<a href="index.html">
								<img class="img-fluid for-light" src="{{ asset("assets/images/logo/logo.png") }}" alt="" />
								<img class="img-fluid for-dark" src="{{ asset("assets/images/logo/logo_dark.png") }}" alt="" />
							</a>
						</div>
						<div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i></div>
					</div>
					<div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
						<ul class="nav-menus">
							<li class="fullscreen-body">
								<span>
									<svg id="maximize-screen">
										<use href="{{ asset("assets/svg/icon-sprite.svg#full-screen") }}"></use>
									</svg>
								</span>
							</li>
							<li>
								<div class="mode">
									<svg>
										<use href="{{ asset("assets/svg/icon-sprite.svg#moon") }}"></use>
									</svg>
								</div>
							</li>
							<li class="profile-nav onhover-dropdown pe-0 py-0">
								<div class="d-flex profile-media">
									<img class="b-r-10" src="{{ asset("assets/images/dashboard/profile.png") }}" alt="" />
									<div class="flex-grow-1">
										<span>{{ session("name") }}</span>
										<p class="mb-0">
											{{ session("role") }}
											<i class="middle fa-solid fa-angle-down"></i>
										</p>
									</div>
								</div>
								<ul class="profile-dropdown onhover-show-div">
									<li>
										<a href="#">
											<i data-feather="user"></i>
											<span>Profile</span>
										</a>
									</li>
									<li>
										<form action="{{ route('logout') }}" method="POST" style="margin:0">
											
											<button type="submit" style="background:none;border:none;padding:0;width:100%;text-align:left;cursor:pointer;display:flex;align-items:center;gap:8px;color:inherit;font:inherit">
												<i data-feather="log-in"></i>
												<span>Log out</span>
											</button>
										</form>
									</li>
								</ul>
							</li>
						</ul>
					</div>
					<script class="result-template" type="text/x-handlebars-template">
						<div class='ProfileCard u-cf'>
							<div class='ProfileCard-avatar'>
								<svg
									xmlns='http://www.w3.org/2000/svg'
									width='24'
									height='24'
									viewBox='0 0 24 24'
									fill='none'
									stroke='currentColor'
									stroke-width='2'
									stroke-linecap='round'
									stroke-linejoin='round'
									class='feather feather-airplay m-0'
								>
									<path d='M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1'></path>
									<polygon points='12 15 17 21 7 21 12 15'></polygon>
								</svg>
							</div>
							<div class='ProfileCard-details'>
								<div class='ProfileCard-realName'>
									TES
								</div>
							</div>
						</div>
					</script>
					<script class="empty-template" type="text/x-handlebars-template">
						<div class='EmptyMessage'>
							Your search turned up 0 results. This most likely means the backend is down, yikes!
						</div>
					</script>
				</div>
			</div>
			<div class="page-body-wrapper">
				<div class="sidebar-wrapper" data-sidebar-layout="stroke-svg">
					<div>
						<div class="logo-wrapper">
							<a href="index.html">
								<img class="img-fluid for-light" src="{{ asset("assets/images/logo/logo.png") }}" alt="" />
								<img class="img-fluid for-dark" src="{{ asset("assets/images/logo/logo_dark.png") }}" alt="" />
							</a>
							<div class="back-btn"><i class="fa-solid fa-angle-left"></i></div>
							<div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"></i></div>
						</div>
						<div class="logo-icon-wrapper">
							<a href="index.html"><img class="img-fluid" src="{{ asset("assets/images/logo/logo-icon.png") }}" alt="" /></a>
						</div>
						<nav class="sidebar-main">
							<div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
							<div id="sidebar-menu">
								<ul class="sidebar-links" id="simple-bar">
									<li class="back-btn">
										<a href="index.html">
											<img class="img-fluid" src="{{ asset("assets/images/logo/logo-icon.png") }}" alt="" />
										</a>
										<div class="mobile-back text-end">
											<span>Back</span>
											<i class="fa-solid fa-angle-right ps-2" aria-hidden="true"></i>
										</div>
									</li>
									<li class="pin-title sidebar-main-title">
										<div>
											<h6>Pinned</h6>
										</div>
									</li>
									<li class="sidebar-main-title">
										<div>
											<h6 class="lan-1">General</h6>
										</div>
									</li>
									<li class="sidebar-list">
										<i class="fa-solid fa-thumbtack"></i>
										<label class="badge badge-light-primary">13</label>
										<a class="sidebar-link sidebar-title" href="#">
											<svg class="stroke-icon">
												<use href="{{ asset("assets/svg/icon-sprite.svg#stroke-home") }}"></use>
											</svg>
											<svg class="fill-icon">
												<use href="{{ asset("assets/svg/icon-sprite.svg#fill-home") }}"></use>
											</svg>
											<span class="lan-3">Dashboard</span>
										</a>
										<ul class="sidebar-submenu">
											<li><a class="lan-4" href="index.html">Default</a></li>
											<li><a class="lan-5" href="dashboard-02.html">Ecommerce</a></li>
											<li><a href="dashboard-03.html">Online course</a></li>
											<li><a href="dashboard-04.html">Crypto</a></li>
											<li><a href="dashboard-05.html">Social</a></li>
											<li><a href="dashboard-06.html">NFT</a></li>
											<li><a href="dashboard-07.html">School management</a></li>
											<li><a href="dashboard-08.html">POS</a></li>
											<li>
												<label class="badge badge-light-success">New</label>
												<a href="dashboard-09.html">CRM</a>
											</li>
											<li>
												<label class="badge badge-light-success">New</label>
												<a href="dashboard-10.html">Analytics</a>
											</li>
											<li>
												<label class="badge badge-light-success">New</label>
												<a href="dashboard-11.html">HR</a>
											</li>
											<li>
												<label class="badge badge-light-success">New</label>
												<a href="dashboard-12.html">Projects</a>
											</li>
											<li>
												<label class="badge badge-light-success">New</label>
												<a href="dashboard-13.html">Logistics</a>
											</li>
										</ul>
									</li>
								</ul>
							</div>
							<div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
						</nav>
					</div>
				</div>
				<div class="page-body">
					<div class="container-fluid">
						<div class="page-title">
							<div class="row">
								<div class="col-sm-6">
									<h3>Default</h3>
								</div>
								<div class="col-sm-6">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="index.html">
												<svg class="stroke-icon">
													<use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
												</svg>
											</a>
										</li>
										<li class="breadcrumb-item">Dashboard</li>
										<li class="breadcrumb-item active">Default</li>
									</ol>
								</div>
							</div>
						</div>
					</div>
					<div class="container-fluid">
						@include("partial.alerts")

						@yield("content")
					</div>
				</div>
				<footer class="footer">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12 footer-copyright text-center">
								<p class="mb-0">
									Copyright
									<span class="year-update"></span>
									© Cuba Theme By Pixelstrap
								</p>
							</div>
						</div>
					</div>
				</footer>
			</div>
		</div>
		<script src="{{ asset("assets/js/jquery.min.js") }}"></script>
		<script src="{{ asset("assets/js/bootstrap/bootstrap.bundle.min.js") }}"></script>
		<script src="{{ asset("assets/js/icons/feather-icon/feather.min.js") }}"></script>
		<script src="{{ asset("assets/js/icons/feather-icon/feather-icon.js") }}"></script>
		<script src="{{ asset("assets/js/scrollbar/simplebar.min.js") }}"></script>
		<script src="{{ asset("assets/js/scrollbar/custom.js") }}"></script>
		<script src="{{ asset("assets/js/config.js") }}"></script>
		<script src="{{ asset("assets/js/sidebar-menu.js") }}"></script>
		<script src="{{ asset("assets/js/script.js") }}"></script>
		<script src="{{ asset("assets/js/script1.js") }}"></script>
		@yield("scripts")
	</body>
</html>
