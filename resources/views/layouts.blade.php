<!DOCTYPE html>
<html lang="id">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<link rel="icon" href="{{ asset("assets/images/favicon.png") }}" type="image/x-icon" />
		<link rel="shortcut icon" href="{{ asset("assets/images/favicon.png") }}" type="image/x-icon" />
		<title>@yield("title", "Dashboard") — MyRepublic</title>

		<link
			href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700&family=DM+Sans:wght@400;500;600&display=swap"
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

		<style>
			:root {
				--theme-default: #5b0ea6;
				--theme-secondary: #c8102e;
				--brand-purple: #5b0ea6;
				--brand-red: #c8102e;
			}

			.page-wrapper.compact-wrapper .page-header {
				background: #ffffff;
				border-bottom: 1px solid #ede9f8;
				box-shadow: 0 1px 16px rgba(91, 14, 166, 0.07);
			}

			.page-header .nav-menus > li > span:hover svg,
			.page-header .nav-menus > li > div.mode:hover svg {
				stroke: var(--brand-purple);
			}

			.page-header .profile-media .flex-grow-1 > span {
				font-weight: 700;
				font-size: 14px;
			}

			.page-header .profile-media .flex-grow-1 > p {
				color: var(--brand-purple);
				font-size: 12px;
				font-weight: 500;
			}

			.profile-dropdown.onhover-show-div {
				border: 1px solid #ede9f8;
				border-radius: 12px;
				box-shadow: 0 8px 28px rgba(26, 23, 38, 0.12);
				padding: 8px;
				right: 0;
				left: auto;
				min-width: 160px;
			}

			.profile-dropdown li a,
			.profile-dropdown li button {
				display: flex;
				align-items: center;
				gap: 10px;
				padding: 10px 16px;
				width: 100%;
				background: none;
				border: none;
				text-align: left;
				cursor: pointer;
				color: inherit;
				font: inherit;
				white-space: nowrap;
				border-radius: 8px;
				text-decoration: none;
			}

			.profile-dropdown li a:hover,
			.profile-dropdown li button:hover {
				background: #f5f3fc;
			}

			.profile-dropdown li a span,
			.profile-dropdown li button span {
				text-transform: none;
				font-size: 13.5px;
			}

			.profile-dropdown li form {
				margin: 0;
			}

			.page-body .page-title {
				border-bottom: 1px solid #ede9f8;
				margin-bottom: 0;
				padding: 18px 0 16px;
			}

			.page-body .page-title h3 {
				font-size: 20px;
				font-weight: 700;
				color: #1a1726;
			}

			.page-body .page-title .breadcrumb-item.active {
				color: var(--brand-purple);
				font-weight: 500;
			}

			.footer {
				background: #faf9ff;
				border-top: 1px solid #ede9f8;
			}

			.footer p {
				color: #9490b0;
				font-size: 13px;
			}

			.select2-container--default .select2-selection--single {
				position: relative;
				height: calc(1.5em + 0.75rem + 2px);
				border: 1px solid #ced4da;
				border-radius: 0.375rem;
				padding: 0;
				display: flex;
				align-items: center;
			}
			.select2-container--default .select2-selection--single .select2-selection__rendered {
				line-height: calc(1.5em + 0.75rem + 8px) !important;
				padding: 0 3.75rem 0 0.75rem !important;
				color: #495057;
				flex: 1;
				overflow: hidden;
				text-overflow: ellipsis;
				white-space: nowrap;
			}
			.select2-container--default .select2-selection--single .select2-selection__placeholder {
				color: #6c757d;
			}
			.select2-container--default .select2-selection--single .select2-selection__arrow {
				position: absolute !important;
				right: 0 !important;
				top: 0 !important;
				height: 100% !important;
				width: 2rem !important;
			}
			.select2-container--default .select2-selection--single .select2-selection__arrow b {
				border-color: #6c757d transparent transparent transparent;
				border-style: solid;
				border-width: 5px 4px 0 4px;
				position: absolute;
				top: 50%;
				left: 50%;
				margin-top: -2px;
				margin-left: -4px;
			}
			.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
				border-color: transparent transparent #6c757d transparent;
				border-width: 0 4px 5px 4px;
				margin-top: -3px;
			}
			.select2-container--default .select2-selection--single .select2-selection__clear {
				position: absolute !important;
				right: 2.25rem !important;
				top: 50% !important;
				transform: translateY(-50%) !important;
				float: none !important;
				margin: 0 !important;
				font-size: 1rem;
				line-height: 1;
				color: #6c757d;
				font-weight: 400;
			}
			.select2-container--default .select2-selection--single .select2-selection__clear:hover {
				color: #dc3545;
			}
			.select2-container--default.select2-container--focus .select2-selection--single,
			.select2-container--default.select2-container--open .select2-selection--single {
				border-color: #86b7fe;
				box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
				outline: 0;
			}
		</style>

		@yield("styles")
	</head>
	<body>
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
										placeholder="Cari di sini..."
										name="q"
										title=""
										autofocus
									/>
									<div class="spinner-border Typeahead-spinner" role="status">
										<span class="sr-only">Loading...</span>
									</div>
									<i class="close-search" data-feather="x"></i>
								</div>
								<div class="Typeahead-menu"></div>
							</div>
						</div>
					</form>

					<div class="header-logo-wrapper col-auto p-0">
						<div class="logo-wrapper">
							<a href="{{ route("home") }}">
								<img class="img-fluid for-light" src="{{ asset("assets/images/logo/logo.png") }}" alt="MyRepublic" />
								<img class="img-fluid for-dark" src="{{ asset("assets/images/logo/logo_dark.png") }}" alt="MyRepublic" />
							</a>
						</div>
						<div class="toggle-sidebar">
							<i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
						</div>
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
										<form action="{{ route("logout") }}" method="POST">
											@csrf
											<button type="submit">
												<i data-feather="log-out"></i>
												<span>Sign Out</span>
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
								<div class='ProfileCard-realName'></div>
							</div>
						</div>
					</script>
					<script class="empty-template" type="text/x-handlebars-template">
						<div class='EmptyMessage'>Tidak ada hasil ditemukan.</div>
					</script>
				</div>
			</div>

			<div class="page-body-wrapper">
				<div class="sidebar-wrapper" data-sidebar-layout="stroke-svg">
					<div>
						<div class="logo-wrapper">
							<a href="{{ route("home") }}">
								<img class="img-fluid for-light" src="{{ asset("assets/images/logo/logo.png") }}" alt="MyRepublic" />
								<img class="img-fluid for-dark" src="{{ asset("assets/images/logo/logo_dark.png") }}" alt="MyRepublic" />
							</a>
							<div class="back-btn"><i class="fa-solid fa-angle-left"></i></div>
							<div class="toggle-sidebar">
								<i class="status_toggle middle sidebar-toggle" data-feather="grid"></i>
							</div>
						</div>
						<div class="logo-icon-wrapper">
							<a href="{{ route("home") }}">
								<img class="img-fluid" src="{{ asset("assets/images/logo/logo-icon.png") }}" alt="" />
							</a>
						</div>
						<nav class="sidebar-main">
							<div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
							<div id="sidebar-menu">
								<ul class="sidebar-links" id="simple-bar">
									<li class="back-btn">
										<a href="{{ route("home") }}">
											<img class="img-fluid" src="{{ asset("assets/images/logo/logo-icon.png") }}" alt="" />
										</a>
										<div class="mobile-back text-end">
											<span>Back</span>
											<i class="fa-solid fa-angle-right ps-2" aria-hidden="true"></i>
										</div>
									</li>

									<li class="sidebar-main-title">
										<div>
											<h6>Menu</h6>
										</div>
									</li>

									<li class="sidebar-list">
										<a
											class="sidebar-link sidebar-title {{ request()->routeIs("home") ? "active" : "" }}"
											href="{{ route("home") }}"
										>
											<svg class="stroke-icon">
												<use href="{{ asset("assets/svg/icon-sprite.svg#stroke-home") }}"></use>
											</svg>
											<svg class="fill-icon">
												<use href="{{ asset("assets/svg/icon-sprite.svg#fill-home") }}"></use>
											</svg>
											<span>Dashboard</span>
										</a>
									</li>

									<li class="sidebar-main-title">
										<div>
											<h6>Administrator</h6>
										</div>
									</li>

									<li class="sidebar-list">
										<a
											class="sidebar-link sidebar-title {{ request()->routeIs("admin.area.*") || request()->routeIs("admin.role.*") || request()->routeIs("admin.employee.*") ? "active" : "" }}"
											href="#"
										>
											<svg class="stroke-icon">
												<use href="{{ asset("assets/svg/icon-sprite.svg#stroke-user") }}"></use>
											</svg>
											<svg class="fill-icon">
												<use href="{{ asset("assets/svg/icon-sprite.svg#fill-user") }}"></use>
											</svg>
											<span>Administrator</span>
										</a>
										<ul class="sidebar-submenu">
											<li>
												<a
													href="{{ route("admin.area.index") }}"
													class="{{ request()->routeIs("admin.area.*") ? "active" : "" }}"
												>
													Area
												</a>
											</li>
											<li>
												<a
													href="{{ route("admin.role.index") }}"
													class="{{ request()->routeIs("admin.role.*") ? "active" : "" }}"
												>
													Role
												</a>
											</li>
											<li>
												<a
													href="{{ route("admin.employee.index") }}"
													class="{{ request()->routeIs("admin.employee.*") ? "active" : "" }}"
												>
													Employee
												</a>
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
							<div class="row align-items-center">
								<div class="col-sm-6 col-12">
									<h3>@yield("title", "Dashboard")</h3>
								</div>
								<div class="col-sm-6 col-12">
									<ol class="breadcrumb justify-content-sm-end">
										<li class="breadcrumb-item">
											<a href="{{ route("home") }}">
												<svg class="stroke-icon">
													<use href="{{ asset("assets/svg/icon-sprite.svg#stroke-home") }}"></use>
												</svg>
											</a>
										</li>
										@yield("breadcrumb")
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
									&copy;
									<span class="year-update"></span>
									PT Telkom Akses &mdash; MyRepublic Kalimantan
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
		<script>
			$(function () {
				var currentPath = window.location.pathname;

				$('.sidebar-submenu a').each(function () {
					var linkPath = new URL($(this).attr('href'), window.location.origin).pathname;
					if (currentPath === linkPath) {
						$(this).addClass('active');
					}
				});

				var $activeLink = $('.sidebar-submenu a.active');
				if ($activeLink.length) {
					var $submenu = $activeLink.closest('.sidebar-submenu');
					var $title = $submenu.prev('.sidebar-title');
					$title.addClass('active');
					$title.find('.according-menu i').removeClass('fa-angle-right').addClass('fa-angle-down');
					$submenu.show();
				}
			});
		</script>
		@yield("scripts")
	</body>
</html>
