<!DOCTYPE html>
<html lang="id">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<link rel="icon" href="{{ asset("assets/images/favicon.png") }}" type="image/x-icon" />
		<title>Daftar — MyRepublic</title>

		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link
			href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700&family=DM+Sans:wght@400;500;600&display=swap"
			rel="stylesheet"
		/>
		<link rel="stylesheet" href="{{ asset("assets/css/vendors/sweetalert2.css") }}" />
		<link rel="stylesheet" href="{{ asset("assets/css/vendors/select2.css") }}" />

		<style>
			:root {
				--red: #c8102e;
				--purple: #5b0ea6;
				--grad: linear-gradient(145deg, #c8102e 0%, #8d1168 45%, #5b0ea6 100%);
				--surface: #ffffff;
				--surface-2: #f7f6fb;
				--border: #e3e0f0;
				--text: #1a1726;
				--muted: #6d6880;
				--ph: #aba8c0;
				--focus-ring: rgba(91, 14, 166, 0.09);
			}

			@media (prefers-color-scheme: dark) {
				:root:not([data-theme='light']) {
					--surface: #12101f;
					--surface-2: #1c1830;
					--border: #2d2945;
					--text: #f0eef8;
					--muted: #9490b0;
					--ph: #5a5675;
				}
			}
			:root[data-theme='dark'] {
				--surface: #12101f;
				--surface-2: #1c1830;
				--border: #2d2945;
				--text: #f0eef8;
				--muted: #9490b0;
				--ph: #5a5675;
			}

			*,
			*::before,
			*::after {
				box-sizing: border-box;
				margin: 0;
				padding: 0;
			}

			body {
				font-family: 'DM Sans', system-ui, sans-serif;
				min-height: 100vh;
				display: flex;
				background: #ffffff;
				color: #1a1726;
				overflow-x: hidden;
			}

			.brand {
				width: 36%;
				flex-shrink: 0;
				background: var(--grad);
				position: relative;
				overflow: hidden;
				display: flex;
				flex-direction: column;
				justify-content: space-between;
				padding: 48px 52px 48px 48px;
				clip-path: polygon(0 0, 100% 0, 88% 100%, 0 100%);
			}

			.brand-dots {
				position: absolute;
				inset: 0;
				background-image: radial-gradient(rgba(255, 255, 255, 0.18) 1px, transparent 1px);
				background-size: 30px 30px;
				opacity: 0.35;
				pointer-events: none;
			}

			.brand-arc {
				position: absolute;
				border-radius: 50%;
				border-style: solid;
				border-color: rgba(255, 255, 255, 0.1);
				pointer-events: none;
			}

			.arc-a {
				width: 500px;
				height: 500px;
				border-width: 1.5px;
				top: -200px;
				right: -220px;
			}
			.arc-b {
				width: 320px;
				height: 320px;
				border-width: 1px;
				top: -120px;
				right: -140px;
			}
			.arc-c {
				width: 160px;
				height: 160px;
				border-width: 1px;
				top: -55px;
				right: -65px;
			}
			.arc-d {
				width: 400px;
				height: 400px;
				border-width: 1.5px;
				bottom: -200px;
				left: -180px;
				border-color: rgba(255, 255, 255, 0.07);
			}
			.arc-e {
				width: 240px;
				height: 240px;
				border-width: 1px;
				bottom: -110px;
				left: -90px;
			}

			.brand-top {
				position: relative;
				z-index: 1;
				display: flex;
				align-items: center;
				gap: 14px;
			}

			.brand-top img {
				height: 26px;
				filter: brightness(0) invert(1);
				opacity: 0.92;
			}

			.brand-sep {
				width: 1px;
				height: 22px;
				background: rgba(255, 255, 255, 0.3);
			}

			.brand-top-label {
				font-family: 'Plus Jakarta Sans', sans-serif;
				font-size: 11px;
				font-weight: 600;
				letter-spacing: 0.1em;
				text-transform: uppercase;
				color: rgba(255, 255, 255, 0.8);
			}

			.brand-mid {
				position: relative;
				z-index: 1;
			}

			.brand-eyebrow {
				font-size: 11px;
				font-weight: 600;
				letter-spacing: 0.14em;
				text-transform: uppercase;
				color: rgba(255, 255, 255, 0.5);
				margin-bottom: 14px;
			}

			.brand-headline {
				font-family: 'Plus Jakarta Sans', sans-serif;
				font-size: 28px;
				font-weight: 700;
				line-height: 1.25;
				color: #fff;
				text-wrap: balance;
				margin-bottom: 18px;
			}

			.brand-desc {
				font-size: 13.5px;
				line-height: 1.75;
				color: rgba(255, 255, 255, 0.6);
			}

			.brand-bottom {
				position: relative;
				z-index: 1;
			}

			.brand-pill {
				display: inline-flex;
				align-items: center;
				gap: 7px;
				padding: 7px 14px;
				background: rgba(255, 255, 255, 0.1);
				border: 1px solid rgba(255, 255, 255, 0.18);
				border-radius: 24px;
				font-size: 12px;
				color: rgba(255, 255, 255, 0.8);
				font-weight: 500;
				backdrop-filter: blur(4px);
			}

			.pill-dot {
				width: 6px;
				height: 6px;
				border-radius: 50%;
				background: #4ade80;
				flex-shrink: 0;
				box-shadow: 0 0 0 2px rgba(74, 222, 128, 0.3);
			}

			.form-panel {
				flex: 1;
				display: flex;
				align-items: center;
				justify-content: center;
				padding: 48px 64px;
				background: #ffffff;
				color: #1a1726;
				overflow-y: auto;
				--surface: #ffffff;
				--surface-2: #f7f6fb;
				--border: #e3e0f0;
				--text: #1a1726;
				--muted: #6d6880;
				--ph: #aba8c0;
				--focus-ring: rgba(91, 14, 166, 0.09);
				--purple: #5b0ea6;
			}

			.form-wrap {
				width: 100%;
				max-width: 540px;
			}

			.form-head {
				margin-bottom: 32px;
			}

			.form-tag {
				font-size: 11.5px;
				font-weight: 600;
				letter-spacing: 0.1em;
				text-transform: uppercase;
				color: var(--purple);
				margin-bottom: 10px;
			}

			.form-title {
				font-family: 'Plus Jakarta Sans', sans-serif;
				font-size: 24px;
				font-weight: 700;
				color: var(--text);
				text-wrap: balance;
				margin-bottom: 6px;
				line-height: 1.25;
			}

			.form-sub {
				font-size: 14px;
				color: var(--muted);
				line-height: 1.6;
			}

			.row-2 {
				display: grid;
				grid-template-columns: 1fr 1fr;
				gap: 16px;
				margin-bottom: 16px;
			}

			.field {
				margin-bottom: 16px;
			}

			.field label {
				display: block;
				font-size: 13px;
				font-weight: 500;
				color: var(--text);
				margin-bottom: 7px;
			}

			.input-box {
				position: relative;
			}

			.input-box input {
				width: 100%;
				height: 48px;
				padding: 0 14px;
				border: 1.5px solid var(--border);
				border-radius: 10px;
				font-family: inherit;
				font-size: 14px;
				color: var(--text);
				background: var(--surface-2);
				outline: none;
				transition:
					border-color 0.18s,
					background 0.18s,
					box-shadow 0.18s;
				-webkit-appearance: none;
			}

			.input-box input::placeholder {
				color: var(--ph);
			}

			.input-box input:focus {
				border-color: var(--purple);
				background: var(--surface);
				box-shadow: 0 0 0 3.5px var(--focus-ring);
			}

			.input-box input.err {
				border-color: #dc2626;
				background: #fff8f8;
			}
			.field-err {
				font-size: 12px;
				color: #dc2626;
				margin-top: 5px;
			}

			.pw-eye {
				position: absolute;
				right: 13px;
				top: 50%;
				transform: translateY(-50%);
				background: none;
				border: none;
				cursor: pointer;
				color: var(--muted);
				display: flex;
				align-items: center;
				padding: 4px;
				transition: color 0.15s;
			}
			.pw-eye:hover {
				color: var(--text);
			}
			.has-eye input {
				padding-right: 44px;
			}

			.select2-container {
				width: 100% !important;
			}
			.select2-container--default .select2-selection--single {
				height: 48px !important;
				padding: 0 14px !important;
				border: 1.5px solid var(--border) !important;
				border-radius: 10px !important;
				background: var(--surface-2) !important;
				outline: none;
				box-shadow: none !important;
				transition:
					border-color 0.18s,
					box-shadow 0.18s !important;
				position: relative;
			}

			.select2-container--default.select2-container--open .select2-selection--single,
			.select2-container--default.select2-container--focus .select2-selection--single {
				border-color: var(--purple) !important;
				background: var(--surface) !important;
				box-shadow: 0 0 0 3.5px var(--focus-ring) !important;
			}

			.select2-container--default .select2-selection--single .select2-selection__rendered {
				padding: 0 28px 0 0 !important;
				font-family: 'DM Sans', sans-serif !important;
				font-size: 14px !important;
				color: var(--text) !important;
				line-height: 45px !important;
			}

			.select2-container--default .select2-selection--single .select2-selection__placeholder {
				color: var(--ph) !important;
			}

			.select2-container--default .select2-selection--single .select2-selection__arrow {
				height: 100% !important;
				top: 0 !important;
				right: 12px !important;
				width: 16px;
			}

			.select2-container--default .select2-selection--single .select2-selection__arrow b {
				border-color: var(--muted) transparent transparent transparent !important;
			}

			.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
				border-color: transparent transparent var(--purple) transparent !important;
			}

			.select2-dropdown {
				border: 1.5px solid #e3e0f0 !important;
				border-radius: 10px !important;
				box-shadow: 0 8px 24px rgba(26, 23, 38, 0.1) !important;
				background: #ffffff !important;
				overflow: hidden;
			}

			.select2-search--dropdown {
				padding: 8px 10px !important;
			}

			.select2-search--dropdown .select2-search__field {
				border: 1.5px solid #e3e0f0 !important;
				border-radius: 8px !important;
				padding: 7px 10px !important;
				font-family: 'DM Sans', sans-serif !important;
				font-size: 13.5px !important;
				outline: none;
				color: #1a1726 !important;
				background: #f7f6fb !important;
			}

			.select2-search--dropdown .select2-search__field:focus {
				border-color: #5b0ea6 !important;
			}

			.select2-container--default .select2-results__option {
				padding: 10px 14px !important;
				font-family: 'DM Sans', sans-serif !important;
				font-size: 14px !important;
				color: #1a1726 !important;
				background: #ffffff !important;
			}

			.select2-container--default .select2-results__option--highlighted[aria-selected] {
				background: #5b0ea6 !important;
				color: #fff !important;
			}

			.select2-container--default .select2-results__option[aria-selected='true'] {
				background: #f7f6fb !important;
				color: #5b0ea6 !important;
				font-weight: 600;
			}

			.field.has-err .select2-container--default .select2-selection--single {
				border-color: #dc2626 !important;
				background: #fff8f8 !important;
			}

			.captcha-row {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.cap-img {
				height: 48px;
				border-radius: 10px;
				border: 1.5px solid var(--border);
				cursor: pointer;
				flex-shrink: 0;
				transition: opacity 0.15s;
			}
			.cap-img:hover {
				opacity: 0.85;
			}
			.cap-hint {
				font-size: 11.5px;
				color: var(--muted);
				margin-top: 5px;
			}

			.agree-row {
				display: flex;
				align-items: flex-start;
				gap: 9px;
				margin-bottom: 24px;
			}
			.agree-row input[type='checkbox'] {
				width: 16px;
				height: 16px;
				accent-color: var(--purple);
				flex-shrink: 0;
				margin-top: 2px;
				cursor: pointer;
			}
			.agree-row label {
				font-size: 13px;
				color: var(--muted);
				line-height: 1.5;
				cursor: pointer;
			}
			.agree-row a {
				color: var(--purple);
				font-weight: 500;
				text-decoration: none;
			}
			.agree-row a:hover {
				text-decoration: underline;
			}

			.btn-cta {
				width: 100%;
				height: 50px;
				background: var(--grad);
				border: none;
				border-radius: 10px;
				font-family: 'Plus Jakarta Sans', sans-serif;
				font-size: 15px;
				font-weight: 600;
				color: #fff;
				cursor: pointer;
				letter-spacing: 0.01em;
				position: relative;
				overflow: hidden;
				transition: transform 0.12s;
			}
			.btn-cta::after {
				content: '';
				position: absolute;
				inset: 0;
				background: rgba(255, 255, 255, 0);
				transition: background 0.18s;
			}
			.btn-cta:hover::after {
				background: rgba(255, 255, 255, 0.08);
			}
			.btn-cta:active {
				transform: scale(0.985);
			}

			.form-foot {
				text-align: center;
				margin-top: 22px;
				font-size: 13.5px;
				color: var(--muted);
			}
			.form-foot a {
				color: var(--purple);
				font-weight: 600;
				text-decoration: none;
			}
			.form-foot a:hover {
				text-decoration: underline;
			}

			@media (max-width: 960px) {
				body {
					flex-direction: column;
				}
				.brand {
					width: 100%;
					clip-path: polygon(0 0, 100% 0, 100% 80%, 0 100%);
					padding: 32px 28px 60px;
				}
				.brand-desc,
				.brand-bottom {
					display: none;
				}
				.brand-headline {
					font-size: 22px;
				}
				.form-panel {
					padding: 40px 20px 60px;
				}
				.row-2 {
					grid-template-columns: 1fr;
				}
			}
		</style>
	</head>
	<body>
		<div class="brand">
			<div class="brand-dots"></div>
			<div class="brand-arc arc-a"></div>
			<div class="brand-arc arc-b"></div>
			<div class="brand-arc arc-c"></div>
			<div class="brand-arc arc-d"></div>
			<div class="brand-arc arc-e"></div>

			<div class="brand-top">
				<img src="{{ asset("assets/images/logo/logo_dark.png") }}" alt="MyRepublic" />
				<div class="brand-sep"></div>
				<span class="brand-top-label">Telkom Akses</span>
			</div>

			<div class="brand-mid">
				<div class="brand-eyebrow">Pendaftaran Akun</div>
				<h1 class="brand-headline">
					Bergabung dengan
					<br />
					Tim Lapangan
				</h1>
				<p class="brand-desc">
					Daftarkan akun Anda untuk mengakses sistem manajemen layanan MyRepublic di wilayah Kalimantan.
				</p>
			</div>
		</div>

		<div class="form-panel">
			<div class="form-wrap">
				<div class="form-head">
					<div class="form-tag">Buat Akun Baru</div>
					<h2 class="form-title">Lengkapi Data Diri Anda</h2>
					<p class="form-sub">Isi semua field berikut untuk mendaftarkan akun karyawan.</p>
				</div>

				<form action="{{ route("signup.post") }}" method="POST" novalidate>
					@csrf

					<div class="row-2">
						<div class="field">
							<label for="nama">Nama Lengkap</label>
							<div class="input-box">
								<input
									id="nama"
									type="text"
									name="nama"
									value="{{ old("nama") }}"
									placeholder="Nama lengkap"
									required
									class="{{ $errors->has("nama") ? "err" : "" }}"
								/>
							</div>
							@error("nama")
								<div class="field-err">{{ $message }}</div>
							@enderror
						</div>

						<div class="field">
							<label for="nik">NIK Karyawan</label>
							<div class="input-box">
								<input
									id="nik"
									type="text"
									name="nik"
									value="{{ old("nik") }}"
									placeholder="NIK karyawan"
									maxlength="12"
									required
									class="{{ $errors->has("nik") ? "err" : "" }}"
								/>
							</div>
							@error("nik")
								<div class="field-err">{{ $message }}</div>
							@enderror
						</div>
					</div>

					<div class="row-2">
						<div class="field">
							<label for="pw1">Password</label>
							<div class="input-box has-eye">
								<input
									id="pw1"
									type="password"
									name="password"
									placeholder="Min. 8 karakter"
									required
									class="{{ $errors->has("password") ? "err" : "" }}"
								/>
								<button type="button" class="pw-eye" onclick="togglePw('pw1', this)" aria-label="Tampilkan">
									<svg
										width="17"
										height="17"
										viewBox="0 0 24 24"
										fill="none"
										stroke="currentColor"
										stroke-width="2"
										stroke-linecap="round"
										stroke-linejoin="round"
									>
										<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
										<circle cx="12" cy="12" r="3" />
									</svg>
								</button>
							</div>
							@error("password")
								<div class="field-err">{{ $message }}</div>
							@enderror
						</div>

						<div class="field">
							<label for="pw2">Konfirmasi Password</label>
							<div class="input-box has-eye">
								<input id="pw2" type="password" name="password_confirmation" placeholder="Ulangi password" required />
								<button type="button" class="pw-eye" onclick="togglePw('pw2', this)" aria-label="Tampilkan">
									<svg
										width="17"
										height="17"
										viewBox="0 0 24 24"
										fill="none"
										stroke="currentColor"
										stroke-width="2"
										stroke-linecap="round"
										stroke-linejoin="round"
									>
										<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
										<circle cx="12" cy="12" r="3" />
									</svg>
								</button>
							</div>
						</div>
					</div>

					<div class="row-2">
						<div class="field {{ $errors->has("area_id") ? "has-err" : "" }}">
							<label>Area</label>
							<select class="s2-area" name="area_id">
								<option value="">Pilih Area</option>
								@foreach ($areas as $area)
									<option value="{{ $area->id }}" {{ old("area_id") == $area->id ? "selected" : "" }}>
										{{ $area->name }}
									</option>
								@endforeach
							</select>
							@error("area_id")
								<div class="field-err">{{ $message }}</div>
							@enderror
						</div>

						<div class="field {{ $errors->has("role_id") ? "has-err" : "" }}">
							<label>Role</label>
							<select class="s2-role" name="role_id">
								<option value="">Pilih Role</option>
								@foreach ($roles as $role)
									<option value="{{ $role->id }}" {{ old("role_id") == $role->id ? "selected" : "" }}>
										{{ $role->name }}
									</option>
								@endforeach
							</select>
							@error("role_id")
								<div class="field-err">{{ $message }}</div>
							@enderror
						</div>
					</div>

					<div class="field">
						<label>Kode Verifikasi</label>
						<div class="captcha-row">
							<img id="cap" class="cap-img" src="{{ route("captcha") }}" alt="Captcha" width="120" height="48" />
							<div class="input-box" style="flex: 1">
								<input
									type="text"
									name="captcha"
									placeholder="Ketik kode di atas"
									autocomplete="off"
									required
									class="{{ $errors->has("captcha") ? "err" : "" }}"
								/>
							</div>
						</div>
						<div class="cap-hint">Klik gambar untuk memperbarui kode</div>
						@error("captcha")
							<div class="field-err">{{ $message }}</div>
						@enderror
					</div>

					<div class="agree-row">
						<input type="checkbox" id="agree" required />
						<label for="agree">
							Saya menyetujui
							<a href="#">syarat dan ketentuan</a>
							serta kebijakan privasi yang berlaku.
						</label>
					</div>

					<button type="submit" class="btn-cta">Daftar</button>

					<div class="form-foot">
						Sudah punya akun?
						<a href="{{ route("signin") }}">Masuk</a>
					</div>
				</form>
			</div>
		</div>

		@include("partial.alerts")

		<script src="{{ asset("assets/js/jquery.min.js") }}"></script>
		<script src="{{ asset("assets/js/sweet-alert/sweetalert.min.js") }}"></script>
		<script src="{{ asset("assets/js/select2/select2.full.min.js") }}"></script>
		<script>
			$(function () {
				$('.s2-area').select2({ placeholder: 'Pilih Area', width: '100%' });
				$('.s2-role').select2({ placeholder: 'Pilih Role', width: '100%' });
			});

			document.getElementById('cap').addEventListener('click', function () {
				this.src = '{{ route("captcha") }}?r=' + Math.random();
			});

			function togglePw(id, btn) {
				const el = document.getElementById(id);
				const show = el.type === 'password';
				el.type = show ? 'text' : 'password';
				btn.innerHTML = show
					? `<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
					: `<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
			}
		</script>
	</body>
</html>
