<!DOCTYPE html>
<html lang="id">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<link rel="icon" type="image/png" sizes="192x192" href="{{ asset("assets/images/favicon-192x192.png") }}" />
		<link rel="icon" type="image/png" href="{{ asset("assets/images/favicon.png") }}" />
		<link rel="apple-touch-icon" sizes="180x180" href="{{ asset("assets/images/apple-touch-icon.png") }}" />
		<title>Masuk — MoraRepublic</title>

		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link
			href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700&family=DM+Sans:wght@400;500;600&display=swap"
			rel="stylesheet"
		/>
		<link rel="stylesheet" href="{{ asset("assets/css/vendors/sweetalert2.css") }}" />

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
				width: 43%;
				flex-shrink: 0;
				background: var(--grad);
				position: relative;
				overflow: hidden;
				display: flex;
				flex-direction: column;
				justify-content: space-between;
				padding: 48px 56px 48px 52px;
				clip-path: polygon(0 0, 100% 0, 90% 100%, 0 100%);
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
				right: -210px;
			}
			.arc-b {
				width: 340px;
				height: 340px;
				border-width: 1px;
				top: -130px;
				right: -140px;
			}
			.arc-c {
				width: 180px;
				height: 180px;
				border-width: 1px;
				top: -65px;
				right: -70px;
			}
			.arc-d {
				width: 420px;
				height: 420px;
				border-width: 1.5px;
				bottom: -200px;
				left: -180px;
				border-color: rgba(255, 255, 255, 0.07);
			}
			.arc-e {
				width: 260px;
				height: 260px;
				border-width: 1px;
				bottom: -120px;
				left: -100px;
			}

			.brand-top {
				position: relative;
				z-index: 1;
				display: flex;
				align-items: center;
				gap: 14px;
			}

			.brand-top img {
				height: 64px;
				filter: brightness(0) invert(1);
				opacity: 0.92;
			}

			.brand-sep {
				width: 1px;
				height: 24px;
				background: rgba(255, 255, 255, 0.3);
			}

			.brand-partner-logo {
				height: 28px;
				filter: brightness(0) invert(1);
				opacity: 0.88;
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
				font-size: 33px;
				font-weight: 700;
				line-height: 1.22;
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
				padding: 60px 64px;
				background: #ffffff;
				color: #1a1726;
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
				max-width: 400px;
			}

			.form-head {
				margin-bottom: 36px;
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
				font-size: 26px;
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

			.field {
				margin-bottom: 20px;
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

			.remember {
				display: flex;
				align-items: center;
				gap: 8px;
				margin-bottom: 28px;
			}

			.remember input[type='checkbox'] {
				width: 16px;
				height: 16px;
				accent-color: var(--purple);
				cursor: pointer;
				flex-shrink: 0;
			}

			.remember label {
				font-size: 13px;
				color: var(--muted);
				cursor: pointer;
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
				margin-top: 24px;
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

			@media (max-width: 900px) {
				body {
					flex-direction: column;
				}

				.brand {
					width: 100%;
					clip-path: polygon(0 0, 100% 0, 100% 82%, 0 100%);
					padding: 36px 32px 64px;
				}

				.brand-mid {
					margin-top: 24px;
				}
				.brand-headline {
					font-size: 24px;
				}
				.brand-desc,
				.brand-bottom {
					display: none;
				}

				.form-panel {
					padding: 40px 24px 60px;
					align-items: flex-start;
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
				<img src="{{ asset("assets/images/logo/logo_dark.png") }}" alt="MoraRepublic" />
				<div class="brand-sep"></div>
				<img
					src="{{ asset("assets/images/logo/logo_telkomakses.png") }}"
					alt="Telkom Akses"
					class="brand-partner-logo"
					style="height: 50px !important"
				/>
			</div>

			<div class="brand-mid">
				<p class="brand-desc">© {{ date("Y") }} PT Telkom Akses Branch Palangkaraya.</p>
			</div>
		</div>

		<div class="form-panel">
			<div class="form-wrap">
				<div class="form-head">
					<div class="form-tag">Portal Masuk</div>
					<h2 class="form-title">Selamat Datang Kembali</h2>
					<p class="form-sub">Masuk menggunakan NIK dan password akun Anda.</p>
				</div>

				<form action="{{ route("signin.post") }}" method="POST" novalidate>
					@csrf

					<div class="field">
						<label for="nik">NIK Karyawan</label>
						<div class="input-box">
							<input
								id="nik"
								type="text"
								name="nik"
								value="{{ old("nik") }}"
								placeholder="Masukkan NIK Anda"
								maxlength="12"
								autocomplete="username"
								required
								class="{{ $errors->has("nik") ? "err" : "" }}"
							/>
						</div>
						@error("nik")
							<div class="field-err">{{ $message }}</div>
						@enderror
					</div>

					<div class="field">
						<label for="pw">Password</label>
						<div class="input-box has-eye">
							<input
								id="pw"
								type="password"
								name="password"
								placeholder="••••••••"
								autocomplete="current-password"
								required
								class="{{ $errors->has("password") ? "err" : "" }}"
							/>
							<button type="button" class="pw-eye" onclick="togglePw('pw', this)" aria-label="Tampilkan password">
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

					<div class="remember">
						<input type="checkbox" id="remember" name="remember" />
						<label for="remember">Ingat saya di perangkat ini</label>
					</div>

					<button type="submit" class="btn-cta">Masuk</button>

					<div class="form-foot">
						Belum punya akun?
						<a href="{{ route("signup") }}">Daftar Sekarang</a>
					</div>
				</form>
			</div>
		</div>

		@include("partial.alerts")

		<script src="{{ asset("assets/js/jquery.min.js") }}"></script>
		<script src="{{ asset("assets/js/sweet-alert/sweetalert.min.js") }}"></script>
		<script>
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
