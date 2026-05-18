<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register — Perpustakaan Digital</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --cream:  #f5f0e8;
            --ink:    #1c1a14;
            --brown:  #5c3d1e;
            --amber:  #b8821a;
            --gold:   #d4a843;
            --rust:   #8b3a2a;
            --muted:  #7a6e5c;
            --border: #c9b99a;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 24px 20px;
            font-family: 'Lato', sans-serif;
            background:
                linear-gradient(rgba(45,27,20,.65), rgba(45,27,20,.65)),
                linear-gradient(135deg, #3e2723 0%, #5d4037 45%, #8d6e63 100%);
        }

        /* ── Card lebih lebar ── */
        .card-wrapper {
            width: 100%;
            max-width: 1000px;       /* lebih lebar dari 800px */
            display: flex;
            overflow: hidden;
            border-radius: 6px;
            box-shadow: 0 30px 80px rgba(0,0,0,.6), 0 0 0 1px rgba(212,168,67,0.15);
            animation: cardIn 0.8s cubic-bezier(0.22,1,0.36,1) both;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(24px) scale(0.97); }
            to   { opacity: 1; transform: none; }
        }

        /* ── Left panel lebih sempit ── */
        .panel-left {
            width: 32%;              /* dikurangi dari 42% */
            background: linear-gradient(180deg, #1a120a, #0f0905);
            padding: 40px 30px;
            color: #f5f0e8;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
            border-right: 1px solid rgba(212,168,67,0.15);
        }

        .panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='30' cy='30' r='1' fill='%23d4a843' opacity='0.06'/%3E%3C/svg%3E") repeat;
            pointer-events: none;
        }

        .logo-icon {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, var(--amber), var(--gold));
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 8px rgba(212,168,67,0.1);
            position: relative;
        }

        .logo-icon svg {
            width: 34px; height: 34px;
            fill: none;
            stroke: var(--ink);
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .panel-left h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            color: var(--gold);
            margin-bottom: 10px;
        }

        .panel-left p {
            color: #d7c9b0;
            line-height: 1.8;
            font-size: .9rem;
        }

        /* ── Right panel ── */
        .panel-right {
            flex: 1;
            background: var(--cream);
            padding: 36px 40px;      /* padding atas-bawah dikurangi */
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 18px;
            text-decoration: none;
            color: var(--muted);
            font-size: .85rem;
            transition: color .2s;
        }

        .back-link:hover { color: var(--brown); }

        .back-link svg {
            width: 13px; height: 13px;
            stroke: currentColor; fill: none;
            stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round;
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.7rem;
            color: var(--ink);
            margin-bottom: 4px;
        }

        .form-subtitle {
            color: var(--muted);
            margin-bottom: 22px;
            font-size: .9rem;
        }

        /* ── 2-column grid untuk form ── */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px 20px;
        }

        /* Field yang butuh full width (misal alamat) */
        .field-full {
            grid-column: 1 / -1;
        }

        .field label {
            display: block;
            margin-bottom: 6px;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--brown);
        }

        .input-wrap { position: relative; }

        .input-wrap input {
            width: 100%;
            height: 42px;
            border: 1.5px solid var(--border);
            background: #faf7f1;
            border-radius: 4px;
            padding: 0 42px 0 14px;
            font-family: 'Lato', sans-serif;
            font-size: .9rem;
            color: var(--ink);
            outline: none;
            transition: border-color .25s, box-shadow .25s;
        }

        .input-wrap input::placeholder { color: #b0a48c; }

        .input-wrap input:focus {
            border-color: var(--amber);
            box-shadow: 0 0 0 3px rgba(184,130,26,.12);
            background: #fff;
        }

        /* Tanpa icon kanan */
        .input-wrap.no-right input { padding-right: 14px; }

        .icon-toggle {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            width: 17px; height: 17px;
            stroke: var(--muted); fill: none;
            stroke-width: 1.8;
            transition: stroke .2s;
        }

        .icon-toggle:hover { stroke: var(--amber); }

        .field-error {
            font-size: 11px;
            color: var(--rust);
            margin-top: 4px;
        }

        /* ── Checkbox & button di bawah grid ── */
        .bottom-section { margin-top: 16px; }

        .checkbox-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 16px;
            color: var(--muted);
            font-size: .88rem;
        }

        .checkbox-row input[type="checkbox"] {
            appearance: none;
            width: 16px; height: 16px;
            border: 1.5px solid var(--border);
            border-radius: 2px;
            background: #faf7f1;
            cursor: pointer;
            position: relative;
            flex-shrink: 0;
            margin-top: 2px;
            transition: background .2s, border-color .2s;
        }

        .checkbox-row input[type="checkbox"]:checked {
            background: var(--amber);
            border-color: var(--amber);
        }

        .checkbox-row input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            top: 2px; left: 4px;
            width: 5px; height: 8px;
            border: 2px solid #fff;
            border-top: none; border-left: none;
            transform: rotate(45deg);
        }

        .btn-submit {
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 4px;
            background: linear-gradient(135deg, var(--brown), var(--amber));
            color: #fff;
            font-family: 'Lato', sans-serif;
            font-weight: 700;
            font-size: .8rem;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: .25s;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent, rgba(255,255,255,.08));
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(92,61,30,.3);
        }

        .login-link {
            text-align: center;
            margin-top: 16px;
            color: var(--muted);
            font-size: .88rem;
        }

        .login-link a {
            color: var(--brown);
            text-decoration: none;
            font-weight: 700;
            transition: color .2s;
        }

        .login-link a:hover { color: var(--amber); }

        /* ── Error alert ── */
        .alert {
            background: #fef0ee;
            border-left: 3px solid var(--rust);
            color: var(--rust);
            font-size: 13px;
            padding: 10px 14px;
            border-radius: 2px;
            margin-bottom: 16px;
        }

        /* ── Responsive ── */
        @media (max-width: 700px) {
            .panel-left { display: none; }
            .card-wrapper { border-radius: 0; }
            .panel-right { padding: 32px 24px; }
            .form-grid { grid-template-columns: 1fr; }
            .field-full { grid-column: 1; }
        }
    </style>
</head>
<body>

<div class="card-wrapper">

    {{-- ── Left decorative panel ── --}}
    <div class="panel-left">
        <div class="logo-icon">
            <svg viewBox="0 0 24 24">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
            </svg>
        </div>
        <h2>Digital Library</h2>
        <p>
            Bergabunglah dan mulai menjelajahi
            dunia pengetahuan bersama kami.
        </p>
    </div>

    {{-- ── Right form panel ── --}}
    <div class="panel-right">

        <a href="{{ route('landing') }}" class="back-link">
            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali ke beranda
        </a>

        <h1 class="form-title">Buat Akun Baru</h1>
        <p class="form-subtitle">Daftar untuk mulai menggunakan perpustakaan digital</p>

        @if ($errors->any())
            <div class="alert">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- 2-column grid --}}
            <div class="form-grid">

                {{-- Nama Lengkap --}}
                <div class="field">
                    <label for="nama">Nama Lengkap</label>
                    <div class="input-wrap no-right">
                        <input type="text" id="nama" name="nama"
                            value="{{ old('nama') }}"
                            placeholder="Cristiano Ronaldo" required>
                    </div>
                    @error('nama') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                {{-- No Telepon --}}
                <div class="field">
                    <label for="telepon">No. Telepon</label>
                    <div class="input-wrap no-right">
                        <input type="text" id="telepon" name="telepon"
                            value="{{ old('telepon') }}"
                            placeholder="08xxxxxxxxxx" required>
                    </div>
                    @error('telepon') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                {{-- Alamat — full width --}}
                <div class="field field-full">
                    <label for="alamat">Alamat</label>
                    <div class="input-wrap no-right">
                        <input type="text" id="alamat" name="alamat"
                            value="{{ old('alamat') }}"
                            placeholder="Jl. Mawar No. 10" required>
                    </div>
                    @error('alamat') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                {{-- Email — full width --}}
                <div class="field field-full">
                    <label for="email">Email</label>
                    <div class="input-wrap no-right">
                        <input type="email" id="email" name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com" required>
                    </div>
                    @error('email') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <input type="password" id="password" name="password"
                            placeholder="Masukkan password" required>
                        <svg class="icon-toggle" id="togglePassword" viewBox="0 0 24 24">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </div>
                    @error('password') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="field">
                    <label for="confirmPassword">Konfirmasi Password</label>
                    <div class="input-wrap">
                        <input type="password" id="confirmPassword" name="password_confirmation"
                            placeholder="Ulangi password" required>
                        <svg class="icon-toggle" id="toggleConfirmPassword" viewBox="0 0 24 24">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </div>
                </div>

            </div>{{-- /form-grid --}}

            <div class="bottom-section">
                <label class="checkbox-row">
                    <input type="checkbox" required>
                    <span>Saya menyetujui syarat dan ketentuan yang berlaku</span>
                </label>

                <button type="submit" class="btn-submit">Buat Akun</button>
            </div>

        </form>

        <div class="login-link">
            Sudah punya akun? <a href="{{ route('login') }}">Login sekarang</a>
        </div>

    </div>
</div>

<script>
    function setupToggle(toggleId, inputId) {
        const toggle = document.getElementById(toggleId);
        const input  = document.getElementById(inputId);
        if (!toggle || !input) return;
        toggle.addEventListener('click', () => {
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            toggle.style.stroke = show ? 'var(--amber)' : 'var(--muted)';
        });
    }

    setupToggle('togglePassword',        'password');
    setupToggle('toggleConfirmPassword', 'confirmPassword');
</script>

</body>
</html>