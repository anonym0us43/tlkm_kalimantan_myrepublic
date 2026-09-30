<!DOCTYPE html>
<html lang="id">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<link rel="icon" type="image/png" sizes="192x192" href="{{ asset("assets/images/favicon-192x192.png") }}" />
		<link rel="icon" type="image/png" href="{{ asset("assets/images/favicon.png") }}" />
		<link rel="shortcut icon" href="{{ asset("assets/images/favicon.png") }}" />
		<link rel="apple-touch-icon" sizes="180x180" href="{{ asset("assets/images/apple-touch-icon.png") }}" />
		<title>@yield("title", "Dashboard") — MoraRepublic</title>

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
				--theme-default: #1026a8;
				--theme-secondary: #8e0499;
				--brand-primary: #1026a8;
				--brand-royal: #2b36b4;
				--brand-periwinkle: #6373d5;
				--brand-deep-purple: #521595;
				--brand-purple: #630f94;
				--brand-magenta: #8e0499;
				--brand-pink: #c34bc3;
				--brand-orange: #faaa3c;
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

		<style>
			.admin-datatable .dt-container,
			.admin-datatable .dt-container .table {
				font-size: 12px;
			}

			.select2-container {
				width: 100% !important;
			}

			.select2-container .select2-selection--single {
				height: 40px !important;
				border: 1.5px solid #dee2e6 !important;
				border-radius: 8px !important;
				background: #f9faff !important;
				box-shadow: none !important;
				transition:
					border-color 0.18s,
					box-shadow 0.18s !important;
			}

			.select2-container--default.select2-container--open .select2-selection--single,
			.select2-container--default.select2-container--focus .select2-selection--single {
				border-color: var(--brand-primary) !important;
				background: #fff !important;
				box-shadow: 0 0 0 3px rgba(16, 38, 168, 0.09) !important;
			}

			.select2-container--default .select2-selection--single .select2-selection__rendered {
				line-height: 40px !important;
				font-size: 13.5px !important;
				color: #3a3a50 !important;
				padding-left: 12px !important;
				padding-right: 28px !important;
			}

			.select2-container--default .select2-selection--single .select2-selection__placeholder {
				color: #adb5bd !important;
			}

			.select2-container--default .select2-selection--single .select2-selection__arrow {
				height: 38px !important;
				top: 1px !important;
				right: 8px !important;
			}

			.select2-container--default .select2-selection--single .select2-selection__arrow b {
				border-color: #9490b0 transparent transparent transparent !important;
			}

			.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
				border-color: transparent transparent var(--brand-primary) transparent !important;
			}

			.select2-container--default .select2-selection--single .select2-selection__clear {
				height: 40px;
				line-height: 40px;
				color: #9490b0;
			}

			.select2-container .select2-selection--multiple {
				position: relative !important;
				height: 40px !important;
				border: 1.5px solid #dee2e6 !important;
				border-radius: 8px !important;
				background: #f9faff !important;
				padding: 0 28px 0 10px !important;
				cursor: pointer;
				overflow: hidden;
				box-shadow: none !important;
				transition:
					border-color 0.18s,
					box-shadow 0.18s !important;
			}

			.select2-container--default.select2-container--open .select2-selection--multiple,
			.select2-container--default.select2-container--focus .select2-selection--multiple {
				border-color: var(--brand-primary) !important;
				background: #fff !important;
				box-shadow: 0 0 0 3px rgba(16, 38, 168, 0.09) !important;
			}

			.select2-container--default .select2-selection--multiple .select2-selection__rendered {
				display: flex !important;
				align-items: center;
				flex-wrap: nowrap;
				padding: 0 !important;
				height: 38px;
				overflow: hidden;
			}

			.select2-container--default .select2-selection--multiple .select2-selection__placeholder {
				color: #adb5bd !important;
				font-size: 13.5px !important;
				line-height: 38px !important;
				margin: 0 !important;
			}

			.select2-container--default .select2-selection--multiple .select2-selection__choice {
				display: none !important;
			}

			.select2-container--default .select2-selection--multiple .select2-search--inline {
				display: none !important;
			}

			.select2-container--default .select2-selection--multiple .select2-selection__clear {
				position: absolute !important;
				right: 8px !important;
				top: 50% !important;
				transform: translateY(-50%) !important;
				color: #adb5bd !important;
				font-size: 18px !important;
				line-height: 1 !important;
				margin: 0 !important;
				z-index: 1;
			}

			.select2-container--default .select2-selection--multiple .select2-selection__clear:hover {
				color: #6c757d !important;
			}

			.select2-dropdown {
				border: 1.5px solid #e3e0f0 !important;
				border-radius: 10px !important;
				box-shadow: 0 8px 24px rgba(16, 38, 168, 0.1) !important;
				background: #ffffff !important;
				overflow: hidden;
			}

			.select2-search--dropdown {
				padding: 8px 10px !important;
			}

			.select2-search--dropdown .select2-search__field {
				border: 1.5px solid #e3e0f0 !important;
				border-radius: 7px !important;
				padding: 7px 10px !important;
				font-size: 13px !important;
				outline: none;
				color: #3a3a50 !important;
				background: #f9faff !important;
			}

			.select2-search--dropdown .select2-search__field:focus {
				border-color: var(--brand-primary) !important;
			}

			.select2-container--default .select2-results__option {
				padding: 9px 14px !important;
				font-size: 13.5px !important;
				color: #3a3a50 !important;
				background: #ffffff !important;
			}

			.select2-container--default .select2-results__option--highlighted[aria-selected] {
				background: var(--brand-primary) !important;
				color: #ffffff !important;
			}

			.select2-container--default .select2-results__option[aria-selected='true'] {
				background: rgba(16, 38, 168, 0.06) !important;
				color: var(--brand-primary) !important;
				font-weight: 600;
			}

			.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper {
				transition: transform 0.3s ease !important;
			}

			.page-wrapper.compact-wrapper .page-body-wrapper .page-body {
				transition: margin-left 0.3s ease !important;
			}

			.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper.close_icon {
				width: 265px !important;
				transform: translateX(-265px) !important;
				overflow: hidden !important;
			}

			.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper.close_icon:hover {
				width: 265px !important;
				transform: translateX(-265px) !important;
			}

			.page-wrapper.compact-wrapper .page-header.close_icon {
				margin-left: 0 !important;
				width: 100% !important;
			}

			.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper.close_icon ~ .page-body,
			.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper.close_icon ~ footer {
				margin-left: 0 !important;
			}

			#sidebarHamburger {
				background: none;
				border: none;
				padding: 4px 8px;
				cursor: pointer;
				color: #495057;
				border-radius: 6px;
			}

			#sidebarHamburger:hover {
				background: #f0f1fd;
			}

			#sidebarHamburger svg {
				width: 20px;
				height: 20px;
				stroke: #495057;
			}

			#sidebarHamburger:hover svg {
				stroke: var(--brand-primary);
			}

			.sidebar-closed #sidebarHamburger {
				display: flex !important;
			}

			.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .logo-wrapper {
				position: relative;
			}

			.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .logo-wrapper img {
				max-width: 190px;
			}

			.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .logo-wrapper .toggle-sidebar {
				top: 50%;
				transform: translateY(-50%);
			}
		</style>
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
					<button
						id="sidebarHamburger"
						class="col-auto d-none align-items-center justify-content-center"
						type="button"
						aria-label="Toggle Sidebar"
					>
						<i data-feather="menu"></i>
					</button>
					<div
						class="col-auto d-flex align-items-center"
						id="headerClock"
						style="font-size: 13px; font-weight: 600; color: #495057; white-space: nowrap"
					></div>
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
								<img class="img-fluid for-light" src="{{ asset("assets/images/logo/logo.png") }}" alt="MoraRepublic" />
								<img class="img-fluid for-dark" src="{{ asset("assets/images/logo/logo_dark.png") }}" alt="MoraRepublic" />
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
										<a href="javascript:void(0);">
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
								<img class="img-fluid for-light" src="{{ asset("assets/images/logo/logo.png") }}" alt="MoraRepublic" />
								<img class="img-fluid for-dark" src="{{ asset("assets/images/logo/logo_dark.png") }}" alt="MoraRepublic" />
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
											class="sidebar-link sidebar-title {{ request()->routeIs("dashboard.*") ? "active" : "" }}"
											href="javascript:void(0);"
										>
											<svg class="stroke-icon">
												<use href="{{ asset("assets/svg/icon-sprite.svg#stroke-home") }}"></use>
											</svg>
											<svg class="fill-icon">
												<use href="{{ asset("assets/svg/icon-sprite.svg#fill-home") }}"></use>
											</svg>
											<span>Dashboard</span>
										</a>
										<ul class="sidebar-submenu">
											<li>
												<a
													href="{{ route("dashboard.daily-report") }}"
													class="{{ request()->routeIs("dashboard.daily-report") ? "active" : "" }}"
												>
													Daily Report
												</a>
											</li>
											<li>
												<a
													href="{{ route("dashboard.kpi-ms-maintenance") }}"
													class="{{ request()->routeIs("dashboard.kpi-ms-maintenance") ? "active" : "" }}"
												>
													KPI MS Maintenance
												</a>
											</li>
										</ul>
									</li>

									@if (auth()->user()->isAdministrator())
									<li class="sidebar-main-title">
										<div>
											<h6>Administrator</h6>
										</div>
									</li>

									<li class="sidebar-list">
										<a
											class="sidebar-link sidebar-title {{ request()->routeIs("admin.area.*") || request()->routeIs("admin.role.*") || request()->routeIs("admin.employee.*") ? "active" : "" }}"
											href="javascript:void(0);"
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
									@endif
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
									PT Telkom Akses &mdash; MoraRepublic Kalimantan
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

				(function () {
					var HARI = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
					var BULAN = [
						'Januari',
						'Februari',
						'Maret',
						'April',
						'Mei',
						'Juni',
						'Juli',
						'Agustus',
						'September',
						'Oktober',
						'November',
						'Desember',
					];
					var el = document.getElementById('headerClock');

					function pad(n) {
						return n < 10 ? '0' + n : n;
					}

					function tick() {
						var now = new Date();
						var d = HARI[now.getDay()] + ', ' + now.getDate() + ' ' + BULAN[now.getMonth()] + ' ' + now.getFullYear();
						var t = pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());
						el.textContent = d + ' | ' + t;
					}

					tick();
					setInterval(tick, 1000);
				})();

				var $nav = $('.sidebar-wrapper');
				var $header = $('.page-header');
				var $wrapper = $('#pageWrapper');
				var SIDEBAR_KEY = 'mora-sidebar-closed';

				function applySidebar(closed) {
					if (closed) {
						$nav.addClass('close_icon');
						$header.addClass('close_icon');
						$wrapper.addClass('sidebar-closed');
					} else {
						$nav.removeClass('close_icon');
						$header.removeClass('close_icon');
						$wrapper.removeClass('sidebar-closed');
					}
				}

				applySidebar(localStorage.getItem(SIDEBAR_KEY) === 'true');

				$('.toggle-sidebar').off('click');

				$('.toggle-sidebar, #sidebarHamburger').on('click', function () {
					var willClose = !$nav.hasClass('close_icon');
					localStorage.setItem(SIDEBAR_KEY, willClose ? 'true' : 'false');
					applySidebar(willClose);
					feather.replace();
				});
			});
		</script>
		@yield("scripts")
	</body>
</html>
