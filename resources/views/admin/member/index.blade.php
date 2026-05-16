<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member — Admin Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg:       #0f0d09;
            --surface:  #1a1710;
            --surface2: #221e14;
            --surface3: #2a2518;
            --gold:     #d4a843;
            --amber:    #b8821a;
            --brown:    #5c3d1e;
            --rust:     #8b3a2a;
            --green:    #2d6a4f;
            --cream:    #f5f0e8;
            --border:   rgba(212,168,67,0.12);
            --border2:  rgba(212,168,67,0.25);
            --text:     rgba(237,229,208,0.85);
            --text-dim: rgba(237,229,208,0.4);
            --sidebar-w: 240px;
        }
        body { font-family:'Lato',sans-serif; background:var(--bg); color:var(--text); min-height:100vh; display:flex; }

        /* ─── SIDEBAR ─── */
        .sidebar { width:var(--sidebar-w); min-height:100vh; background:var(--surface); position:fixed; top:0; left:0; bottom:0; border-right:1px solid var(--border); z-index:100; display:flex; flex-direction:column; }
        .sidebar::before { content:''; position:absolute; inset:0; background:url("data:image/svg+xml,%3Csvg width='60' height='60' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='30' cy='30' r='1' fill='%23d4a843' opacity='0.04'/%3E%3C/svg%3E") repeat; pointer-events:none; }
        .brand { padding:22px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:12px; }
        .brand-logo { width:38px; height:38px; background:linear-gradient(135deg,var(--amber),var(--gold)); border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .brand-logo svg { width:20px; height:20px; fill:none; stroke:#1c1a14; stroke-width:2; }
        .brand-text h2 { font-family:'Playfair Display',serif; font-size:13px; font-weight:700; color:var(--gold); line-height:1.2; }
        .brand-text p  { font-size:9px; letter-spacing:2px; text-transform:uppercase; color:var(--rust); margin-top:2px; }
        .nav { flex:1; padding:10px 8px; overflow-y:auto; }
        .nav-group-label { font-size:9px; letter-spacing:2.5px; text-transform:uppercase; color:var(--text-dim); padding:10px 12px 4px; }
        .nav-link { display:flex; align-items:center; gap:10px; padding:9px 12px; border-radius:6px; text-decoration:none; color:var(--text-dim); font-size:13px; transition:all 0.2s; margin-bottom:1px; position:relative; }
        .nav-link svg { width:15px; height:15px; fill:none; stroke:currentColor; stroke-width:1.8; flex-shrink:0; }
        .nav-link:hover { background:rgba(212,168,67,0.07); color:var(--text); }
        .nav-link.active { background:rgba(212,168,67,0.1); color:var(--gold); font-weight:700; }
        .nav-link.active::before { content:''; position:absolute; left:0; top:6px; bottom:6px; width:3px; background:var(--gold); border-radius:0 2px 2px 0; }
        .logout-section { padding:12px 8px; border-top:1px solid var(--border); }
        .logout-btn { width:100%; display:flex; align-items:center; gap:10px; padding:9px 12px; background:transparent; border:none; border-radius:6px; cursor:pointer; color:var(--text-dim); font-family:'Lato',sans-serif; font-size:13px; transition:all 0.2s; }
        .logout-btn svg { width:15px; height:15px; fill:none; stroke:currentColor; stroke-width:1.8; }
        .logout-btn:hover { background:rgba(139,58,42,0.15); color:#f4a49a; }

        /* ─── MAIN ─── */
        .main { margin-left:var(--sidebar-w); flex:1; display:flex; flex-direction:column; min-height:100vh; }
        .topbar { height:58px; background:var(--surface); border-bottom:1px solid var(--border); display:flex; align-items:center; padding:0 28px; gap:14px; position:sticky; top:0; z-index:50; }
        .page-heading { flex:1; }
        .page-heading h1 { font-family:'Playfair Display',serif; font-size:17px; font-weight:600; color:var(--gold); }
        .page-heading p  { font-size:11px; color:var(--text-dim); margin-top:1px; font-weight:300; }

        .btn { display:inline-flex; align-items:center; gap:7px; padding:0 16px; height:36px; border-radius:6px; font-family:'Lato',sans-serif; font-size:12px; font-weight:700; letter-spacing:0.5px; cursor:pointer; border:none; text-decoration:none; transition:all 0.2s; white-space:nowrap; }
        .btn svg { width:13px; height:13px; fill:none; stroke:currentColor; stroke-width:2; }
        .btn-gold   { background:linear-gradient(135deg,var(--brown),var(--amber)); color:var(--cream); }
        .btn-gold:hover { box-shadow:0 4px 16px rgba(184,130,26,0.3); transform:translateY(-1px); }
        .btn-outline{ background:transparent; border:1px solid var(--border2); color:var(--gold); }
        .btn-outline:hover { background:rgba(212,168,67,0.08); }
        .btn-danger { background:rgba(139,58,42,0.18); color:#f4a49a; border:1px solid rgba(139,58,42,0.3); }
        .btn-danger:hover { background:rgba(139,58,42,0.32); }
        .btn-edit   { background:rgba(184,130,26,0.12); color:var(--gold); border:1px solid rgba(212,168,67,0.2); }
        .btn-edit:hover { background:rgba(184,130,26,0.24); }
        .btn-sm     { height:30px; padding:0 10px; font-size:11px; }

        .content { padding:26px 28px; flex:1; }

        /* Stats */
        .stat-strip { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:22px; }
        .stat-box { background:var(--surface2); border:1px solid var(--border); border-radius:8px; padding:16px 18px; display:flex; align-items:center; gap:14px; transition:border-color 0.2s; }
        .stat-box:hover { border-color:var(--border2); }
        .stat-icon { width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .stat-icon svg { width:18px; height:18px; fill:none; stroke-width:1.8; }
        .si-gold  { background:rgba(212,168,67,0.1);  } .si-gold  svg { stroke:var(--gold); }
        .si-green { background:rgba(45,106,79,0.12);  } .si-green svg { stroke:#52b788; }
        .si-rust  { background:rgba(139,58,42,0.12);  } .si-rust  svg { stroke:#f4a49a; }
        .stat-info .num { font-family:'Playfair Display',serif; font-size:26px; font-weight:700; color:var(--cream); line-height:1; }
        .stat-info .lbl { font-size:11px; color:var(--text-dim); margin-top:3px; }

        .alert { padding:11px 16px; border-radius:6px; margin-bottom:18px; font-size:13px; display:flex; align-items:center; gap:10px; animation:slideDown 0.3s ease; }
        @keyframes slideDown { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:none} }
        .alert-success { background:rgba(45,106,79,0.15); border:1px solid rgba(45,106,79,0.3); color:#52b788; }
        .alert-error   { background:rgba(139,58,42,0.15); border:1px solid rgba(139,58,42,0.3); color:#f4a49a; }

        .toolbar { display:flex; align-items:center; gap:10px; margin-bottom:16px; flex-wrap:wrap; }
        .search-box { display:flex; align-items:center; background:var(--surface2); border:1px solid var(--border); border-radius:6px; padding:0 12px; gap:8px; height:38px; flex:1; min-width:180px; transition:border-color 0.2s; }
        .search-box:focus-within { border-color:var(--amber); }
        .search-box svg { width:14px; height:14px; stroke:var(--text-dim); fill:none; stroke-width:2; flex-shrink:0; }
        .search-box input { background:none; border:none; outline:none; font-family:'Lato',sans-serif; font-size:13px; color:var(--text); width:100%; }
        .search-box input::placeholder { color:var(--text-dim); }

        .card { background:var(--surface2); border:1px solid var(--border); border-radius:10px; overflow:hidden; }
        .card-head { padding:14px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; }
        .card-head h3 { font-family:'Playfair Display',serif; font-size:15px; color:var(--gold); }
        .card-head span { font-size:12px; color:var(--text-dim); }
        table { width:100%; border-collapse:collapse; }
        th { font-size:9px; letter-spacing:1.5px; text-transform:uppercase; color:var(--text-dim); font-weight:700; padding:11px 18px; text-align:left; border-bottom:1px solid var(--border); white-space:nowrap; }
        td { padding:13px 18px; font-size:13px; color:var(--text); border-bottom:1px solid var(--border); vertical-align:middle; }
        tbody tr:last-child td { border-bottom:none; }
        tbody tr:hover td { background:rgba(212,168,67,0.035); }
        .cell-title { font-weight:700; color:var(--cream); font-size:13.5px; }
        .cell-sub   { font-size:11px; color:var(--text-dim); margin-top:2px; }
        .no-row { text-align:center; padding:48px; color:var(--text-dim); font-size:14px; }
        .pill { display:inline-block; font-size:10px; font-weight:700; padding:3px 9px; border-radius:20px; }
        .pill-ok     { background:rgba(45,106,79,0.15);  color:#52b788; }
        .pill-danger { background:rgba(139,58,42,0.15);  color:#f4a49a; }
        .actions { display:flex; gap:6px; }
        .pagi-wrap { padding:14px 20px; border-top:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px; }
        .pagi-wrap p { font-size:12px; color:var(--text-dim); }
        .pagination { display:flex; gap:3px; list-style:none; }
        .pagination li span,.pagination li a { display:flex; align-items:center; justify-content:center; min-width:30px; height:30px; padding:0 8px; border-radius:5px; font-size:12px; text-decoration:none; color:var(--text-dim); background:var(--surface3); border:1px solid var(--border); transition:all 0.2s; }
        .pagination li a:hover { border-color:var(--border2); color:var(--gold); }
        .pagination li.active span { background:rgba(212,168,67,0.15); border-color:var(--border2); color:var(--gold); font-weight:700; }

        /* Avatar */
        .avatar { width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,var(--brown),var(--amber)); display:flex; align-items:center; justify-content:center; font-family:'Playfair Display',serif; font-size:13px; font-weight:700; color:var(--cream); flex-shrink:0; }
        .member-cell { display:flex; align-items:center; gap:10px; }

        /* ─── MODAL ─── */
        .modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.8); backdrop-filter:blur(4px); z-index:200; display:none; align-items:center; justify-content:center; }
        .modal-overlay.open { display:flex; animation:fadeIn 0.2s ease; }
        @keyframes fadeIn { from{opacity:0} to{opacity:1} }
        .modal { background:var(--surface2); border:1px solid var(--border2); border-radius:12px; width:540px; max-width:95vw; max-height:90vh; overflow-y:auto; animation:slideUp 0.3s cubic-bezier(0.22,1,0.36,1); }
        @keyframes slideUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:none} }
        .modal-header { padding:18px 24px 14px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; }
        .modal-header h2 { font-family:'Playfair Display',serif; font-size:17px; color:var(--gold); }
        .modal-close { width:28px; height:28px; border-radius:6px; background:rgba(212,168,67,0.08); border:none; cursor:pointer; color:var(--text-dim); font-size:18px; display:flex; align-items:center; justify-content:center; transition:all 0.2s; }
        .modal-close:hover { background:rgba(139,58,42,0.2); color:#f4a49a; }
        .modal-body { padding:18px 24px; }
        .modal-footer { padding:14px 24px 18px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:8px; }
        .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:0 16px; }
        .field { margin-bottom:16px; }
        .field.full { grid-column:1/-1; }
        .field label { display:block; font-size:10px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--amber); margin-bottom:6px; }
        .field input,.field select { width:100%; padding:10px 12px; background:var(--surface3); border:1px solid var(--border); border-radius:6px; color:var(--cream); font-family:'Lato',sans-serif; font-size:13.5px; outline:none; transition:border-color 0.2s,box-shadow 0.2s; }
        .field input::placeholder { color:var(--text-dim); }
        .field select option { background:var(--surface2); }
        .field input:focus,.field select:focus { border-color:var(--amber); box-shadow:0 0 0 3px rgba(184,130,26,0.1); }
        .field-error { font-size:11px; color:#f4a49a; margin-top:4px; }
        .field-hint  { font-size:11px; color:var(--text-dim); margin-top:4px; }

        .delete-body { padding:24px; text-align:center; }
        .delete-body .icon { font-size:44px; margin-bottom:14px; }
        .delete-body h3 { font-family:'Playfair Display',serif; font-size:18px; color:var(--cream); margin-bottom:8px; }
        .delete-body p { font-size:13px; color:var(--text-dim); line-height:1.6; }
        .delete-footer { padding:0 24px 24px; display:flex; gap:8px; justify-content:center; }
    </style>
</head>
<body>

{{-- ═══ SIDEBAR ═══ --}}
<aside class="sidebar">
    <div class="brand">
        <div class="brand-logo">
            <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        </div>
        <div class="brand-text">
            <h2>Perpustakaan</h2>
            <p>Admin Panel</p>
        </div>
    </div>
    <nav class="nav">
        <div class="nav-group-label">Manajemen</div>
        <a href="{{ route('admin.buku.dashboard') }}" class="nav-link">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard Buku
        </a>
        <a href="{{ route('admin.pinjam.index') }}" class="nav-link">
            <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
            Peminjaman
        </a>
        <a href="{{ route('admin.member.index') }}" class="nav-link active">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            Member
        </a>
    </nav>
    <div class="logout-section">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

{{-- ═══ MAIN ═══ --}}
<div class="main">
    <header class="topbar">
        <div class="page-heading">
            <h1>Data Member</h1>
            <p>Kelola member perpustakaan</p>
        </div>
        <button class="btn btn-gold" onclick="openModal('modalTambah')">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Member
        </button>
    </header>

    <div class="content">

        @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-error">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
        @endif

        {{-- Stats --}}
        <div class="stat-strip">
            <div class="stat-box">
                <div class="stat-icon si-gold">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div class="stat-info">
                    <div class="num">{{ $totalMember }}</div>
                    <div class="lbl">Total Member</div>
                </div>
            </div>
            <div class="stat-box">
                <div class="stat-icon si-green">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div class="stat-info">
                    <div class="num">{{ $totalAktif }}</div>
                    <div class="lbl">Sedang Meminjam</div>
                </div>
            </div>
            <div class="stat-box">
                <div class="stat-icon si-rust">
                    <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                </div>
                <div class="stat-info">
                    <div class="num">{{ $totalDenda }}</div>
                    <div class="lbl">Ada Denda Aktif</div>
                </div>
            </div>
        </div>

        {{-- Toolbar --}}
        <form method="GET" action="{{ route('admin.member.index') }}">
            <div class="toolbar">
                <div class="search-box">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, telepon...">
                </div>
                <button type="submit" class="btn btn-outline">Cari</button>
                @if(request('search'))
                <a href="{{ route('admin.member.index') }}" class="btn btn-outline">Reset</a>
                @endif
            </div>
        </form>

        {{-- Table --}}
        <div class="card">
            <div class="card-head">
                <h3>Daftar Member</h3>
                <span>{{ $member->firstItem() }}–{{ $member->lastItem() }} dari {{ $member->total() }}</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Member</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Status Pinjam</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($member as $i => $a)
                    <tr>
                        <td style="color:var(--text-dim);width:40px">
                            {{ ($member->currentPage()-1)*$member->perPage()+$i+1 }}
                        </td>
                        <td>
                            <div class="member-cell">
                                <div class="avatar">{{ strtoupper(substr($a->nama,0,1)) }}</div>
                                <div>
                                    <div class="cell-title">{{ $a->nama }}</div>
                                    <div class="cell-sub">{{ $a->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:12px">{{ $a->telepon ?? '—' }}</td>
                        <td style="font-size:12px;color:var(--text-dim);max-width:160px">
                            {{ Str::limit($a->alamat, 40) ?? '—' }}
                        </td>
                        <td>
                            @php $aktif = $a->pinjam()->where('status','pinjam')->count(); @endphp
                            @if($aktif > 0)
                                <span class="pill pill-ok">{{ $aktif }} buku</span>
                            @else
                                <span class="pill pill-danger" style="background:rgba(100,100,100,0.12);color:var(--text-dim)">Tidak ada</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <button class="btn btn-edit btn-sm"
                                    onclick="openEdit({
                                        id:'{{ $a->id }}',
                                        nama:'{{ addslashes($a->nama) }}',
                                        email:'{{ $a->email }}',
                                        telepon:'{{ $a->telepon }}',
                                        alamat:'{{ addslashes($a->alamat) }}'
                                    })">
                                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Edit
                                </button>
                                <button class="btn btn-danger btn-sm"
                                    onclick="openDelete('{{ $a->id }}','{{ addslashes($a->nama) }}')">
                                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M9 6V4h6v2"/></svg>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="no-row">👤 Belum ada member terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagi-wrap">
                <p>Menampilkan {{ $member->firstItem() ?? 0 }}–{{ $member->lastItem() ?? 0 }} dari {{ $member->total() }} member</p>
                {{ $member->appends(request()->query())->links() }}
            </div>
        </div>

    </div>
</div>

{{-- ═══ MODAL TAMBAH ═══ --}}
<div class="modal-overlay" id="modalTambah">
    <div class="modal">
        <div class="modal-header">
            <h2>Tambah Member Baru</h2>
            <button class="modal-close" onclick="closeModal('modalTambah')">×</button>
        </div>
        <form method="POST" action="{{ route('admin.member.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-grid">
                    <div class="field full">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama member" required>
                        @error('nama')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required>
                        @error('email')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label>No. Telepon</label>
                        <input type="text" name="telepon" value="{{ old('telepon') }}" placeholder="08xx-xxxx-xxxx">
                        @error('telepon')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field full">
                        <label>Alamat</label>
                        <input type="text" name="alamat" value="{{ old('alamat') }}" placeholder="Alamat lengkap">
                        @error('alamat')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Min. 8 karakter" required>
                        @error('password')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('modalTambah')">Batal</button>
                <button type="submit" class="btn btn-gold">Simpan Member</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══ MODAL EDIT ═══ --}}
<div class="modal-overlay" id="modalEdit">
    <div class="modal">
        <div class="modal-header">
            <h2>Edit Data Member</h2>
            <button class="modal-close" onclick="closeModal('modalEdit')">×</button>
        </div>
        <form method="POST" id="formEdit" action="">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-grid">
                    <div class="field full">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" id="edit_nama" required>
                    </div>
                    <div class="field">
                        <label>Email</label>
                        <input type="email" name="email" id="edit_email" required>
                    </div>
                    <div class="field">
                        <label>No. Telepon</label>
                        <input type="text" name="telepon" id="edit_telepon">
                    </div>
                    <div class="field full">
                        <label>Alamat</label>
                        <input type="text" name="alamat" id="edit_alamat">
                    </div>
                    <div class="field full">
                        <label>Password Baru</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak ingin ubah">
                        <p class="field-hint">Biarkan kosong jika tidak ingin mengganti password</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('modalEdit')">Batal</button>
                <button type="submit" class="btn btn-gold">Update Member</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══ MODAL HAPUS ═══ --}}
<div class="modal-overlay" id="modalHapus">
    <div class="modal" style="width:400px">
        <div class="delete-body">
            <div class="icon">🗑️</div>
            <h3>Hapus Member?</h3>
            <p>Kamu akan menghapus member "<strong id="del-nama" style="color:var(--gold)"></strong>". Data peminjaman terkait juga akan terhapus.</p>
        </div>
        <div class="delete-footer">
            <button class="btn btn-outline" onclick="closeModal('modalHapus')">Batal</button>
            <form method="POST" id="formHapus" action="">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('open');
        document.body.style.overflow = '';
    }

    document.querySelectorAll('.modal-overlay').forEach(o => {
        o.addEventListener('click', e => { if(e.target===o) closeModal(o.id); });
    });

    function openEdit(d) {
        document.getElementById('formEdit').action = `/admin/member/${d.id}`;
        document.getElementById('edit_nama').value    = d.nama;
        document.getElementById('edit_email').value   = d.email;
        document.getElementById('edit_telepon').value = d.telepon;
        document.getElementById('edit_alamat').value  = d.alamat;
        openModal('modalEdit');
    }

    function openDelete(id, nama) {
        document.getElementById('formHapus').action = `/admin/member/${id}`;
        document.getElementById('del-nama').textContent = nama;
        openModal('modalHapus');
    }
</script>
</body>
</html>