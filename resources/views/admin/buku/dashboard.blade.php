<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Buku — Admin Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        /* (semua style sama seperti yang Anda berikan, tidak perlu diubah) */
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
        .sidebar::before { content:''; position:absolute; inset:0; background: url("data:image/svg+xml,%3Csvg width='60' height='60' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='30' cy='30' r='1' fill='%23d4a843' opacity='0.04'/%3E%3C/svg%3E") repeat; pointer-events:none; }
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
        
        .main { margin-left:var(--sidebar-w); flex:1; display:flex; flex-direction:column; min-height:100vh; }
        .topbar { height:58px; background:var(--surface); border-bottom:1px solid var(--border); display:flex; align-items:center; padding:0 28px; gap:14px; position:sticky; top:0; z-index:50; }
        .page-heading { flex:1; }
        .page-heading h1 { font-family:'Playfair Display',serif; font-size:17px; font-weight:600; color:var(--gold); }
        .page-heading p  { font-size:11px; color:var(--text-dim); margin-top:1px; font-weight:300; }
        
        .btn { display:inline-flex; align-items:center; gap:7px; padding:0 16px; height:36px; border-radius:6px; font-family:'Lato',sans-serif; font-size:12px; font-weight:700; letter-spacing:0.5px; cursor:pointer; border:none; text-decoration:none; transition:all 0.2s; white-space:nowrap; }
        .btn svg { width:13px; height:13px; fill:none; stroke:currentColor; stroke-width:2; }
        .btn-gold    { background:linear-gradient(135deg,var(--brown),var(--amber)); color:var(--cream); }
        .btn-gold:hover { box-shadow:0 4px 16px rgba(184,130,26,0.3); transform:translateY(-1px); }
        .btn-outline { background:transparent; border:1px solid var(--border2); color:var(--gold); }
        .btn-outline:hover { background:rgba(212,168,67,0.08); }
        .btn-danger  { background:rgba(139,58,42,0.18); color:#f4a49a; border:1px solid rgba(139,58,42,0.3); }
        .btn-danger:hover { background:rgba(139,58,42,0.32); }
        .btn-edit    { background:rgba(184,130,26,0.12); color:var(--gold); border:1px solid rgba(212,168,67,0.2); }
        .btn-edit:hover { background:rgba(184,130,26,0.24); }
        .btn-sm      { height:30px; padding:0 10px; font-size:11px; }
        
        .content { padding:26px 28px; flex:1; }
        
        .stat-strip { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:22px; }
        .stat-box { background:var(--surface2); border:1px solid var(--border); border-radius:8px; padding:16px 18px; display:flex; align-items:center; gap:14px; transition:border-color 0.2s; }
        .stat-box:hover { border-color:var(--border2); }
        .stat-icon { width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .stat-icon svg { width:18px; height:18px; fill:none; stroke-width:1.8; }
        .si-gold  { background:rgba(212,168,67,0.1); } .si-gold  svg { stroke:var(--gold);  }
        .si-green { background:rgba(45,106,79,0.12); } .si-green svg { stroke:#52b788; }
        .si-rust  { background:rgba(139,58,42,0.12); } .si-rust  svg { stroke:#f4a49a; }
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
        tbody tr { transition:background 0.15s; }
        tbody tr:hover td { background:rgba(212,168,67,0.035); }
        .cell-title { font-weight:700; color:var(--cream); font-size:13.5px; }
        .no-row { text-align:center; padding:48px; color:var(--text-dim); font-size:14px; }
        .pill { display:inline-block; font-size:10px; font-weight:700; padding:3px 9px; border-radius:20px; }
        .pill-ok     { background:rgba(45,106,79,0.15);  color:#52b788; }
        .pill-warn   { background:rgba(184,130,26,0.15); color:var(--gold); }
        .pill-danger { background:rgba(139,58,42,0.15);  color:#f4a49a; }
        .actions { display:flex; gap:6px; }
        .pagi-wrap { padding:14px 20px; border-top:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px; }
        .pagi-wrap p { font-size:12px; color:var(--text-dim); }
        .pagination { display:flex; gap:3px; list-style:none; }
        .pagination li span, .pagination li a { display:flex; align-items:center; justify-content:center; min-width:30px; height:30px; padding:0 8px; border-radius:5px; font-size:12px; text-decoration:none; color:var(--text-dim); background:var(--surface3); border:1px solid var(--border); transition:all 0.2s; }
        .pagination li a:hover { border-color:var(--border2); color:var(--gold); }
        .pagination li.active span { background:rgba(212,168,67,0.15); border-color:var(--border2); color:var(--gold); font-weight:700; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="brand">
        <div class="brand-logo">
            <svg viewBox="0 0 24 24">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
            </svg>
        </div>
        <div class="brand-text">
            <h2>Perpustakaan</h2>
            <p>Admin Panel</p>
        </div>
    </div>
    <nav class="nav">
        <div class="nav-group-label">Manajemen</div>
        <a href="{{ route('admin.buku.dashboard') }}" class="nav-link active">
            <svg viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>
            Dashboard Buku
        </a>
        <a href="{{ route('admin.pinjam.index') }}" class="nav-link">
            <svg viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                <path d="M2 17l10 5 10-5"/>
                <path d="M2 12l10 5 10-5"/>
            </svg>
            Peminjaman
        </a>
        <a href="{{ route('admin.anggota.index') }}" class="nav-link">
            <svg viewBox="0 0 24 24">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
            </svg>
            Anggota
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

<div class="main">
    <header class="topbar">
        <div class="page-heading">
            <h1>Kelola Buku</h1>
            <p>Manajemen koleksi buku perpustakaan</p>
        </div>
        <a href="{{ route('admin.buku.create') }}" class="btn btn-gold">
            <svg viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Tambah Buku
        </a>
    </header>
    
    <div class="content">
        @if(session('success')) 
            <div class="alert alert-success">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"/>
                </svg> 
                {{ session('success') }} 
            </div> 
        @endif
        @if(session('error')) 
            <div class="alert alert-error">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg> 
                {{ session('error') }} 
            </div> 
        @endif

        {{--  total koleksi --}}
        <div class="stat-strip">
            <div class="stat-box">
                <div class="stat-icon si-gold">
                    <svg viewBox="0 0 24 24">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <div class="num">{{ $totalBukuAll }}</div>
                    <div class="lbl">Total Koleksi Buku</div>
                </div>
            </div>
        </div>

        <div class="toolbar">
            <form method="GET" action="{{ route('admin.buku.dashboard') }}" style="display:flex;gap:10px;flex:1">
                <div class="search-box">
                    <svg viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, penulis...">
                </div>
                <button type="submit" class="btn btn-outline">Cari</button>
                @if(request('search')) 
                    <a href="{{ route('admin.buku.dashboard') }}" class="btn btn-outline">Reset</a> 
                @endif
            </form>
        </div>

        <div class="card">
            <div class="card-head">
                <h3>Daftar Buku</h3>
                <span>{{ $buku->firstItem() }}–{{ $buku->lastItem() }} dari {{ $buku->total() }} buku</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>ISBN</th>
                        <th>Kategori</th>
                        <th>Status</th>      {{-- kolom status ditambahkan --}}
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buku as $i => $b)
                    <tr>
                        <td style="color:var(--text-dim);width:40px">{{ ($buku->currentPage() - 1) * $buku->perPage() + $i + 1 }}</td>
                        <td><div class="cell-title">{{ $b->judul }}</div></td>
                        <td>{{ $b->penulis }}</td>
                        <td style="font-size:12px;color:var(--text-dim)">{{ $b->penerbit }}</td>
                        <td>{{ $b->tahun }}</td>
                        <td style="font-size:11.5px;color:var(--text-dim)">{{ $b->isbn }}</td>
                        <td style="font-size:12px;color:var(--text-dim)">{{ $b->kategori }}</td>
                        <td>
                            @if($b->status == 'tersedia')
                                <span class="pill pill-ok">Tersedia</span>
                            @else
                                <span class="pill pill-danger">Dipinjam</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.buku.edit', $b->id) }}" class="btn btn-edit btn-sm">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg> 
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.buku.destroy', $b->id) }}" onsubmit="return confirm('Hapus buku {{ addslashes($b->judul) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <svg viewBox="0 0 24 24">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6l-1 14H6L5 6"/>
                                            <path d="M10 11v6"/>
                                            <path d="M14 11v6"/>
                                            <path d="M9 6V4h6v2"/>
                                        </svg> 
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="no-row">
                            📚 Belum ada buku. 
                            <a href="{{ route('admin.buku.create') }}" style="color:var(--amber)">
                                Tambahkan sekarang
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagi-wrap">
                <p>Menampilkan {{ $buku->firstItem() ?? 0 }}–{{ $buku->lastItem() ?? 0 }} dari {{ $buku->total() }} data</p>
                {{ $buku->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>
</div>
</body>
</html>