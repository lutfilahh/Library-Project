<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    // Dashboard daftar buku + pencarian
    public function showDashboard(Request $request)
    {
        $search = $request->input('search');
        
        $buku = Buku::when($search, function ($query, $search) {
            return $query->where('judul', 'like', "%{$search}%")
                         ->orWhere('penulis', 'like', "%{$search}%")
                         ->orWhere('penerbit', 'like', "%{$search}%")
                         ->orWhere('kategori', 'like', "%{$search}%");
        })->latest()->paginate(10)->appends(['search' => $search]);
        
        $totalBukuAll = Buku::count();
        $totalEksemplarAll = Buku::sum('jumlah');
        
        return view('admin.buku.dashboard', compact('buku', 'totalBukuAll', 'totalEksemplarAll'));
    }

    // Tampilkan form tambah buku
    public function showCreateBuku()
    {
        return view('admin.buku.create');
    }

    // Proses simpan buku
    public function create(Request $request)
    {
        $request->validate([
            'judul'    => 'required|string|max:200',
            'penulis'  => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun'    => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'isbn'     => 'required|string|max:100',
            'kategori' => 'required|string|max:100',
            'jumlah'   => 'required|integer|max:100',
        ]);

        Buku::create($request->only(['judul', 'penulis', 'penerbit', 'tahun', 'isbn', 'kategori', 'jumlah']));

        return redirect()->route('admin.dashboard')->with('success', 'Buku berhasil ditambahkan!');
    }

    // Tampilkan form edit
    public function showUpdate($id)
    {
        $buku = Buku::findOrFail($id);
        return view('admin.buku.update', compact('buku'));
    }

    // Proses update buku
    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul'    => 'required|string|max:200',
            'penulis'  => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun'    => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'isbn'     => 'required|string|max:100',
            'kategori' => 'required|string|max:100',
            'jumlah'   => 'required|integer|max:100',
        ]);

        $buku->update($request->only(['judul', 'penulis', 'penerbit', 'tahun', 'isbn', 'kategori', 'jumlah', ]));

        return redirect()->route('admin.dashboard')->with('success', 'Data buku berhasil diperbarui');
    }

    // Hapus buku
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('admin.buku.dashboard')->with('success', 'Buku berhasil dihapus!');
    }
}