<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku — Admin Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        :root { 
            --bg: #0f0d09; 
            --surface: #1a1710; 
            --surface2: #221e14; 
            --gold: #d4a843; 
            --amber: #b8821a; 
            --cream: #f5f0e8; 
            --border: rgba(212,168,67,0.12); 
            --text: rgba(237,229,208,0.85); 
            --text-dim: rgba(237,229,208,0.4); 
            --sidebar-w: 240px; }
        body { font-family:'Lato',sans-serif; background:var(--bg); color:var(--text); display:flex; }
        .sidebar { width:var(--sidebar-w); background:var(--surface); position:fixed; top:0; left:0; bottom:0; border-right:1px solid var(--border); }
        .brand { padding:22px 20px; border-bottom:1px solid var(--border); display:flex; gap:12px; }
        .brand-logo { width:38px; height:38px; background:linear-gradient(135deg,var(--amber),var(--gold)); border-radius:8px; display:flex; align-items:center; justify-content:center; }
        .brand-text h2 { font-family:'Playfair Display',serif; font-size:13px; color:var(--gold); }
        .nav { padding:10px 8px; } 
        .nav-link { display:flex; align-items:center; gap:10px; padding:9px 12px; text-decoration:none; color:var(--text-dim); font-size:13px; border-radius:6px; } 
        .nav-link.active { background:rgba(212,168,67,0.1); color:var(--gold); }
        .logout-section { padding:12px 8px; border-top:1px solid var(--border); }
        .logout-btn { width:100%; text-align:left; background:none; border:none; color:var(--text-dim); cursor:pointer; padding:9px 12px; }
        .main { margin-left:var(--sidebar-w); flex:1; }
        .topbar { height:58px; background:var(--surface); border-bottom:1px solid var(--border); display:flex; align-items:center; padding:0 28px; }
        .page-heading h1 { font-family:'Playfair Display',serif; font-size:17px; color:var(--gold); }
        .content { padding:26px 28px; }
        .card { background:var(--surface2); border:1px solid var(--border); border-radius:10px; padding:20px 28px; max-width:700px; }
        .form-group { margin-bottom:18px; }
        label { display:block; font-size:11px; text-transform:uppercase; letter-spacing:1px; margin-bottom:6px; color:var(--text-dim); }
        input, select { width:100%; background:var(--surface); border:1px solid var(--border); border-radius:6px; padding:10px 12px; font-family:'Lato',sans-serif; font-size:13px; color:var(--text); }
        input:focus { outline:none; border-color:var(--gold); }
        .btn-group { display:flex; gap:12px; margin-top:8px; }
        .btn { padding:8px 20px; border-radius:6px; font-weight:700; text-decoration:none; display:inline-block; font-size:12px; }
        .btn-primary { background:var(--gold); color:#1a1710; }
        .btn-secondary { background:transparent; border:1px solid var(--border); color:var(--text-dim); }
        .error { color:#f4a49a; font-size:11px; margin-top:4px; }
        hr { border-color:var(--border); margin:12px 0; }
    </style>
</head>
<body>
    
<aside class="sidebar">  
    <div class="brand">
        <div class="brand-logo">
            <svg width="20" viewBox="0 0 24 24">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
            </svg>
        </div>
        <div class="brand-text">
            <h2>Perpustakaan</h2>
        </div>
    </div>
    <nav class="nav">
        <a href="{{ route('admin.buku.dashboard') }}" class="nav-link">Dashboard</a>
        <a href="#" class="nav-link active">Kelola Buku</a>
    </nav>
</aside>

<div class="main">
    <header class="topbar">
        <div class="page-heading">
            <h1>Tambah Buku Baru</h1>
        </div>
    </header>

    <div class="content">
        <div class="card">
            <form method="POST" action="{{ route('admin.buku.store') }}">
                @csrf
                <div class="form-group">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required> 
                    @error('judul')
                    <div class="error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Penulis</label>
                    <input type="text" name="penulis" value="{{ old('penulis') }}" required> 
                    @error('penulis')
                    <div class="error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Penerbit</label>
                    <input type="text" name="penerbit" value="{{ old('penerbit') }}" required> 
                    @error('penerbit')
                    <div class="error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Tahun Terbit</label>
                    <input type="number" name="tahun" value="{{ old('tahun') }}" required> 
                    @error('tahun')
                    <div class="error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn') }}" required> 
                    @error('isbn')
                    <div class="error">
                        {{ $message }}
                </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <input type="text" name="kategori" value="{{ old('kategori') }}" required> 
                    @error('kategori')
                    <div class="error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Simpan Buku</button>
                    <a href="{{ route('admin.buku.dashboard') }}" class="btn btn-secondary">Batal</a>
                </div>
                
            </form>
        </div>
    </div>
</div>
</body>
</html>