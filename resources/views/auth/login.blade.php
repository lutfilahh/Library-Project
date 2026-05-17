<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — Perpustakaan Digital</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --cream:     #f5f0e8;
            --parchment: #ede5d0;
            --ink:       #1c1a14;
            --brown:     #5c3d1e;
            --amber:     #b8821a;
            --gold:      #d4a843;
            --rust:      #8b3a2a;
            --muted:     #7a6e5c;
            --border:    #c9b99a;
        }

        html, body { height: 100%; }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
            font-family: 'Lato', sans-serif;
            background:
                linear-gradient(rgba(45,27,20,.65), rgba(45,27,20,.65)),
                linear-gradient(135deg, #3e2723 0%, #5d4037 45%, #8d6e63 100%);
            color: #f8f5f0;
        }

        /* ── Main card ── */
        .card-wrapper {
            position: relative;
            z-index: 10;
            display: flex;
            width: 900px;
            max-width: 95vw;
            min-height: 560px;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0,0,0,0.7), 0 0 0 1px rgba(212,168,67,0.2);
            animation: cardIn 0.9s cubic-bezier(0.22,1,0.36,1) both;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(32px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ── Left panel ── */
        .panel-left {
            flex: 0 0 46%;
            background: linear-gradient(175deg, #2a1a0a 0%, #1a0f05 60%, #0d0804 100%);
            padding: 52px 44px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            border-right: 1px solid rgba(212,168,67,0.15);
        }

        .panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='60' height='60' fill='none'/%3E%3Ccircle cx='30' cy='30' r='1' fill='%23d4a843' opacity='0.06'/%3E%3C/svg%3E") repeat;
            pointer-events: none;
        }

        .ornament-top, .ornament-bottom {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ornament-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(212,168,67,0.5));
        }

        .ornament-bottom .ornament-line {
            background: linear-gradient(90deg, rgba(212,168,67,0.5), transparent);
        }

        .ornament-diamond {
            width: 8px;
            height: 8px;
            background: var(--gold);
            transform: rotate(45deg);
            flex-shrink: 0;
        }

        .logo-area {
            text-align: center;
            padding: 24px 0;
        }

        .logo-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 18px;
            background: linear-gradient(135deg, var(--amber), var(--gold));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 8px rgba(212,168,67,0.1), 0 8px 24px rgba(0,0,0,0.4);
        }

        .logo-icon svg {
            width: 36px;
            height: 36px;
            fill: none;
            stroke: var(--ink);
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .logo-title {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--gold);
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        .logo-subtitle {
            font-size: 11px;
            font-weight: 300;
            color: var(--border);
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-top: 6px;
        }

        .panel-quote { text-align: center; }

        .panel-quote blockquote {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 15px;
            color: rgba(237,229,208,0.6);
            line-height: 1.7;
        }

        .panel-quote cite {
            display: block;
            font-style: normal;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--amber);
            margin-top: 10px;
        }

        /* ── Right panel ── */
        .panel-right {
            flex: 1;
            background: var(--cream);
            padding: 52px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .panel-right::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 120px; height: 120px;
            background: radial-gradient(circle at top right, rgba(184,130,26,0.08), transparent 70%);
            pointer-events: none;
        }

        /* Back link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--muted);
            text-decoration: none;
            margin-bottom: 28px;
            transition: color 0.2s;
        }
        .back-link:hover { color: var(--brown); }
        .back-link svg {
            width: 14px; height: 14px;
            stroke: currentColor; fill: none;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
        }

        .form-heading { margin-bottom: 28px; }

        .form-heading h1 {
            font-family: 'Playfair Display', serif;
            font-size: 30px;
            font-weight: 600;
            color: var(--ink);
            line-height: 1.2;
        }

        .form-heading h1 em {
            font-style: italic;
            color: var(--brown);
        }

        .form-heading p {
            font-size: 13.5px;
            color: var(--muted);
            margin-top: 8px;
            font-weight: 300;
        }

        /* Alert */
        .alert {
            background: #fef0ee;
            border-left: 3px solid var(--rust);
            color: var(--rust);
            font-size: 13px;
            padding: 10px 14px;
            border-radius: 2px;
            margin-bottom: 20px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: none; }
        }

        /* Fields */
        .field { margin-bottom: 20px; }

        .field label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--brown);
            margin-bottom: 7px;
        }

        .input-wrap { position: relative; }

        .input-wrap .icon-left {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px; height: 16px;
            stroke: var(--muted); fill: none;
            stroke-width: 1.8;
            pointer-events: none;
            transition: stroke 0.2s;
        }

        .input-wrap input {
            width: 100%;
            height: 46px;
            padding: 0 42px 0 42px; /* kanan 42px untuk icon toggle */
            font-family: 'Lato', sans-serif;
            font-size: 14px;
            color: var(--ink);
            background: #faf7f1;
            border: 1.5px solid var(--border);
            border-radius: 3px;
            outline: none;
            transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
        }

        .input-wrap input::placeholder { color: #b0a48c; }

        .input-wrap input:focus {
            background: #fff;
            border-color: var(--amber);
            box-shadow: 0 0 0 3px rgba(184,130,26,0.12);
        }

        .input-wrap input:focus ~ .icon-left {
            stroke: var(--amber);
        }

        /* Untuk field email yang tidak punya icon kanan, padding kanan cukup 14px */
        .input-wrap.no-right input {
            padding-right: 14px;
        }

        .icon-toggle {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            width: 18px; height: 18px;
            stroke: var(--muted); fill: none;
            stroke-width: 1.8;
            transition: stroke 0.2s;
        }

        .icon-toggle:hover { stroke: var(--amber); }

        .field-error {
            font-size: 12px;
            color: var(--rust);
            margin-top: 5px;
        }

        /* Remember + Forgot */
        .row-extras {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 26px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 13px;
            color: var(--muted);
            user-select: none;
        }

        .checkbox-label input[type="checkbox"] {
            appearance: none;
            width: 16px; height: 16px;
            border: 1.5px solid var(--border);
            border-radius: 2px;
            background: #faf7f1;
            cursor: pointer;
            position: relative;
            transition: background 0.2s, border-color 0.2s;
            flex-shrink: 0;
        }

        .checkbox-label input[type="checkbox"]:checked {
            background: var(--amber);
            border-color: var(--amber);
        }

        .checkbox-label input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            top: 2px; left: 4px;
            width: 5px; height: 8px;
            border: 2px solid #fff;
            border-top: none; border-left: none;
            transform: rotate(45deg);
        }

        .forgot-link {
            font-size: 12.5px;
            color: var(--amber);
            text-decoration: none;
            transition: color 0.2s;
        }
        .forgot-link:hover { color: var(--brown); text-decoration: underline; }

        /* Submit button */
        .btn-submit {
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, var(--brown) 0%, var(--amber) 100%);
            color: var(--cream);
            font-family: 'Lato', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: box-shadow 0.3s, transform 0.15s;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.08) 100%);
        }

        .btn-submit:hover {
            box-shadow: 0 6px 20px rgba(92,61,30,0.35);
            transform: translateY(-1px);
        }

        .btn-submit:active { transform: translateY(0); }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 22px 0;
            color: var(--border);
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* Register link */
        .register-row {
            text-align: center;
            font-size: 13px;
            color: var(--muted);
        }
        .register-row a {
            color: var(--brown);
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s;
        }
        .register-row a:hover { color: var(--amber); }

        /* Responsive */
        @media (max-width: 700px) {
            .panel-left { display: none; }
            .card-wrapper { width: 100%; min-height: 100vh; border-radius: 0; }
            .panel-right { padding: 44px 28px; }
        }
    </style>
</head>
<body>

<div class="card-wrapper">

    {{-- ── Left decorative panel ── --}}
    <div class="panel-left">
        <div class="ornament-top">
            <div class="ornament-diamond"></div>
            <div class="ornament-line"></div>
            <div class="ornament-diamond"></div>
        </div>

        <div class="logo-area">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                </svg>
            </div>
            <div class="logo-title">Perpustakaan</div>
            <div class="logo-subtitle">Digital Library System</div>
        </div>

        <div class="panel-quote">
            <blockquote>
                "Sebuah buku adalah impian yang kamu pegang di tanganmu."
            </blockquote>
            <cite>— Neil Gaiman</cite>
        </div>

        <div class="ornament-bottom">
            <div class="ornament-diamond"></div>
            <div class="ornament-line"></div>
            <div class="ornament-diamond"></div>
        </div>
    </div>

    {{-- ── Right form panel ── --}}
    <div class="panel-right">

        {{-- Tombol kembali --}}
        <a href="{{ route('landing') }}" class="back-link">
            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali ke beranda
        </a>

        <div class="form-heading">
            <h1>Selamat <em>datang</em></h1>
            <p>Masuk untuk mengakses koleksi buku</p>
        </div>

        {{-- Session / validation errors --}}
        @if (session('error'))
            <div class="alert">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            {{-- Email --}}
            <div class="field">
                <label for="email">Email</label>
                <div class="input-wrap no-right">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        autocomplete="email"
                        autofocus
                        required
                    >
                    <svg class="icon-left" viewBox="0 0 24 24">
                        <rect x="2" y="4" width="20" height="16" rx="2"/>
                        <polyline points="2,4 12,13 22,4"/>
                    </svg>
                </div>
                @error('email')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password — hanya SATU field --}}
            <div class="field">
                <label for="password">Kata Sandi</label>
                <div class="input-wrap">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        autocomplete="current-password"
                        required
                    >
                    <svg class="icon-left" viewBox="0 0 24 24">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    {{-- Toggle show/hide password --}}
                    <svg class="icon-toggle" id="togglePwd" viewBox="0 0 24 24" title="Tampilkan sandi">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </div>
                @error('password')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember me + Forgot password --}}
            <div class="row-extras">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Ingat saya
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa kata sandi?</a>
                @endif
            </div>

            <button type="submit" class="btn-submit">Masuk ke Perpustakaan</button>
        </form>

        @if (Route::has('register'))
            <div class="divider">atau</div>
            <div class="register-row">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
        @endif

    </div>
</div>

{{-- Satu script toggle password --}}
<script>
    (function () {
        const toggle = document.getElementById('togglePwd');
        const pwd    = document.getElementById('password');
        if (!toggle || !pwd) return;

        toggle.addEventListener('click', () => {
            const isHidden = pwd.type === 'password';
            pwd.type = isHidden ? 'text' : 'password';
            toggle.style.stroke = isHidden ? 'var(--amber)' : 'var(--muted)';
        });
    })();
</script>

</body>
</html>