<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun — Perpustakaan Nusantara</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --cream:    #f5f0e8;
            --ink:      #1c1a14;
            --brown:    #5c3d1e;
            --amber:    #b8821a;
            --gold:     #d4a843;
            --rust:     #8b3a2a;
            --green:    #2d6a4f;
            --muted:    #7a6e5c;
            --border:   #c9b99a;
        }

        html, body { height: 100%; }

        body {
            font-family: 'Lato', sans-serif;
            background: linear-gradient(145deg, #e8e0d3 0%, #d9cebc 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px 0;
            position: relative;
            overflow-x: hidden;
        }

        .card-wrapper {
            position: relative;
            z-index: 10;
            display: flex;
            width: 960px;
            max-width: 95vw;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0,0,0,0.7), 0 0 0 1px rgba(212,168,67,0.2);
            animation: cardIn 0.9s cubic-bezier(0.22,1,0.36,1) both;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(28px) scale(0.97); }
            to   { opacity: 1; transform: none; }
        }

        .panel-left {
            flex: 0 0 38%;
            background: linear-gradient(175deg, #2a1a0a 0%, #1a0f05 60%, #0d0804 100%);
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            border-right: 1px solid rgba(212,168,67,0.15);
        }

        .panel-left::before {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='30' cy='30' r='1' fill='%23d4a843' opacity='0.06'/%3E%3C/svg%3E") repeat;
            pointer-events: none;
        }

        .ornament {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ornament-line {
            flex: 1; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(212,168,67,0.5));
        }

        .ornament-diamond {
            width: 7px; height: 7px;
            background: var(--gold);
            transform: rotate(45deg);
            flex-shrink: 0;
        }

        .logo-area {
            text-align: center;
            padding: 20px 0;
        }

        .logo-icon {
            width: 64px; height: 64px;
            margin: 0 auto 16px;
            background: linear-gradient(135deg, var(--amber), var(--gold));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 8px rgba(212,168,67,0.1), 0 8px 24px rgba(0,0,0,0.4);
        }

        .logo-icon svg {
            width: 32px; height: 32px;
            fill: none;
            stroke: var(--ink);
            stroke-width: 2;
        }

        .logo-title {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--gold);
            line-height: 1.2;
        }

        .logo-subtitle {
            font-size: 10px;
            font-weight: 300;
            color: var(--border);
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-top: 6px;
        }

        .steps {
            display: flex;
            flex-direction: column;
            gap: 16px;
            padding: 8px 0;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 14px;
            opacity: 0.4;
            transition: opacity 0.3s;
        }

        .step.active { opacity: 1; }
        .step.done   { opacity: 0.7; }

        .step-num {
            width: 28px; height: 28px;
            border-radius: 50%;
            border: 1.5px solid var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: var(--gold);
            flex-shrink: 0;
        }

        .step.active .step-num {
            background: var(--gold);
            color: var(--ink);
        }

        .step-text {
            font-size: 12px;
            color: var(--border);
            letter-spacing: 0.5px;
        }

        .step.active .step-text {
            color: var(--cream);
            font-weight: 700;
        }

        .panel-right {
            flex: 1;
            background: var(--cream);
            padding: 48px 52px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow-y: auto;
        }

        .panel-right::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 140px; height: 140px;
            background: radial-gradient(circle at top right, rgba(184,130,26,0.07), transparent 70%);
            pointer-events: none;
        }

        .form-heading { margin-bottom: 28px; }

        .form-heading h1 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 600;
            color: var(--ink);
            line-height: 1.2;
        }

        .form-heading h1 em {
            font-style: italic;
            color: var(--brown);
        }

        .form-heading p {
            font-size: 13px;
            color: var(--muted);
            margin-top: 6px;
            font-weight: 300;
        }

        .alert-error {
            background: #fef0ee;
            border-left: 3px solid var(--rust);
            color: var(--rust);
            font-size: 13px;
            padding: 10px 14px;
            border-radius: 2px;
            margin-bottom: 18px;
        }

        .alert-success {
            background: #edf7f2;
            border-left: 3px solid var(--green);
            color: var(--green);
            font-size: 13px;
            padding: 10px 14px;
            border-radius: 2px;
            margin-bottom: 18px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 20px;
        }

        .field {
            margin-bottom: 18px;
        }

        .field.full { grid-column: 1 / -1; }

        .field label {
            display: block;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--brown);
            margin-bottom: 6px;
        }

        .input-wrap { position: relative; }

        .input-wrap svg.icon-left {
            position: absolute;
            left: 13px; top: 50%;
            transform: translateY(-50%);
            width: 15px; height: 15px;
            stroke: var(--muted);
            fill: none;
            stroke-width: 1.8;
            pointer-events: none;
            transition: stroke 0.2s;
        }

        .input-wrap input,
        .input-wrap select {
            width: 100%;
            height: 44px;
            padding: 0 13px 0 40px;
            font-family: 'Lato', sans-serif;
            font-size: 13.5px;
            color: var(--ink);
            background: #faf7f1;
            border: 1.5px solid var(--border);
            border-radius: 3px;
            outline: none;
            transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
        }

        .input-wrap input::placeholder { color: #b0a48c; }

        .input-wrap input:focus,
        .input-wrap select:focus {
            background: #fff;
            border-color: var(--amber);
            box-shadow: 0 0 0 3px rgba(184,130,26,0.12);
        }

        .input-wrap input:focus ~ svg.icon-left,
        .input-wrap select:focus ~ svg.icon-left { stroke: var(--amber); }

        .icon-right {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            width: 15px; height: 15px;
            stroke: var(--muted);
            fill: none;
            stroke-width: 1.8;
            cursor: pointer;
        }

        .strength-bar {
            display: flex;
            gap: 4px;
            margin-top: 6px;
        }

        .strength-bar span {
            flex: 1;
            height: 3px;
            border-radius: 2px;
            background: var(--border);
            transition: background 0.3s;
        }

        .strength-label {
            font-size: 11px;
            color: var(--muted);
            margin-top: 4px;
        }

        .field-error {
            font-size: 11.5px;
            color: var(--rust);
            margin-top: 4px;
        }

        .terms-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 22px;
        }

        .terms-row input[type="checkbox"] {
            appearance: none;
            width: 16px; height: 16px;
            border: 1.5px solid var(--border);
            border-radius: 2px;
            background: #faf7f1;
            cursor: pointer;
            position: relative;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .terms-row input[type="checkbox"]:checked {
            background: var(--amber);
            border-color: var(--amber);
        }

        .terms-row input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            top: 2px; left: 4px;
            width: 5px; height: 8px;
            border: 2px solid #fff;
            border-top: none; border-left: none;
            transform: rotate(45deg);
        }

        .terms-row label {
            font-size: 12.5px;
            color: var(--muted);
            cursor: pointer;
            line-height: 1.5;
        }

        .terms-row label a {
            color: var(--brown);
            text-decoration: underline;
        }

        .btn-register {
            width: 100%;
            height: 46px;
            background: linear-gradient(135deg, var(--brown) 0%, var(--amber) 100%);
            color: var(--cream);
            font-family: 'Lato', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: box-shadow 0.3s, transform 0.15s;
        }

        .btn-register:hover {
            box-shadow: 0 6px 20px rgba(92,61,30,0.35);
            transform: translateY(-1px);
        }

        .login-row {
            text-align: center;
            font-size: 12.5px;
            color: var(--muted);
            margin-top: 18px;
        }

        .login-row a {
            color: var(--brown);
            font-weight: 700;
            text-decoration: none;
        }

        .login-row a:hover { color: var(--amber); }

        @media (max-width: 720px) {
            .panel-left { display: none; }
            .card-wrapper { width: 100%; border-radius: 0; }
            .panel-right { padding: 36px 24px; }
            .form-grid { grid-template-columns: 1fr; }
            .field.full { grid-column: auto; }
        }
    </style>
</head>
<body>

<div class="card-wrapper">
    <div class="panel-left">
        <div class="ornament">
            <div class="ornament-diamond"></div>
            <div class="ornament-line"></div>
            <div class="ornament-diamond"></div>
        </div>
        <div class="logo-area">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <div class="logo-title">Perpustakaan</div>
            <div class="logo-subtitle">Digital Library System</div>
        </div>
        <div class="ornament ornament-rev">
            <div class="ornament-diamond"></div>
            <div class="ornament-line"></div>
            <div class="ornament-diamond"></div>
        </div>
    </div>

    <div class="panel-right">
        <div class="form-heading">
            <h1>Buat akun <em>baru</em></h1>
            <p>Bergabunglah dan nikmati ribuan koleksi buku digital</p>
        </div>

        @if (session('status'))
            <div class="alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-grid">
                {{-- Nama --}}
                <div class="field full">
                    <label for="nama">Nama Lengkap</label>
                    <div class="input-wrap">
                        <input type="text" id="nama" name="nama"
                            value="{{ old('nama') }}"
                            placeholder="Lutfilah Ahmad" autofocus required>
                        <svg class="icon-left" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    </div>
                    @error('nama')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                {{-- Alamat --}}
                <div class="field full">
                    <label for="alamat">Alamat</label>
                    <div class="input-wrap">
                        <input type="text" id="alamat" name="alamat"
                            value="{{ old('alamat') }}"
                            placeholder="Jl. Merdeka No. 123, Jakarta" required>
                        <svg class="icon-left" viewBox="0 0 24 24"><path d="M12 2a8 8 0 0 0-8 8c0 5 8 12 8 12s8-7 8-12a8 8 0 0 0-8-8z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    @error('alamat')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                {{-- Telepon --}}
                <div class="field">
                    <label for="telepon">No. Telepon</label>
                    <div class="input-wrap">
                        <input type="tel" id="telepon" name="telepon"
                            value="{{ old('telepon') }}"
                            placeholder="08xx-xxxx-xxxx">
                        <svg class="icon-left" viewBox="0 0 24 24"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 2 .7 2.9a2 2 0 0 1-.4 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.5c.9.3 1.9.6 2.9.7A2 2 0 0 1 22 16.9z"/></svg>
                    </div>
                    @error('telepon')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                {{-- Email --}}
                <div class="field">
                    <label for="email">Alamat Email</label>
                    <div class="input-wrap">
                        <input type="email" id="email" name="email"
                            value="{{ old('email') }}"
                            placeholder="lutfi@email.com" required>
                        <svg class="icon-left" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><polyline points="2,4 12,13 22,4"/></svg>
                    </div>
                    @error('email')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                {{-- Password --}}
                <div class="field">
                    <label for="password">Kata Sandi</label>
                    <div class="input-wrap">
                        <input type="password" id="password" name="password"
                            placeholder="Min. 8 karakter" required
                            oninput="checkStrength(this.value)">
                        <svg class="icon-left" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <svg class="icon-right" id="togglePwd1" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </div>
                    <div class="strength-bar"><span id="s1"></span><span id="s2"></span><span id="s3"></span><span id="s4"></span></div>
                    <p class="strength-label" id="strengthLabel"></p>
                    @error('password')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="field">
                    <label for="password_confirmation">Konfirmasi Sandi</label>
                    <div class="input-wrap">
                        <input type="password" id="password_confirmation"
                            name="password_confirmation" required>
                        <svg class="icon-left" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <svg class="icon-right" id="togglePwd2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </div>
                </div>
            </div>

            <div class="terms-row">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">
                    Saya menyetujui <a href="#">Syarat &amp; Ketentuan</a>
                    dan <a href="#">Kebijakan Privasi</a> Perpustakaan Nusantara
                </label>
            </div>

            <button type="submit" class="btn-register">Buat Akun Sekarang</button>
        </form>

        <div class="login-row">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </div>
</div>

<script>
    function togglePass(btnId, inputId) {
        const btn = document.getElementById(btnId);
        if (btn) {
            btn.addEventListener('click', () => {
                const input = document.getElementById(inputId);
                if (input) {
                    input.type = input.type === 'password' ? 'text' : 'password';
                }
            });
        }
    }
    togglePass('togglePwd1', 'password');
    togglePass('togglePwd2', 'password_confirmation');

    function checkStrength(val) {
        const bars = [document.getElementById('s1'), document.getElementById('s2'), document.getElementById('s3'), document.getElementById('s4')];
        const label = document.getElementById('strengthLabel');
        const colors = ['#8b3a2a','#b8821a','#d4a843','#2d6a4f'];
        const labels = ['Sangat lemah','Cukup','Kuat','Sangat kuat'];
        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;
        bars.forEach((b, i) => { if (b) b.style.background = i < score ? colors[score-1] : 'var(--border)'; });
        if (label) {
            label.textContent = val.length > 0 ? (labels[score-1] ?? '') : '';
            label.style.color = score > 0 ? colors[score-1] : 'var(--muted)';
        }
    }
</script>
</body>
</html>