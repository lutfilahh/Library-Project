<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Pinjam;

class BukuController extends Controller
{
    // Dashboard daftar buku +
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
        
        return view('admin.buku.dashboard', compact('buku', 'totalBukuAll'));
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
        ]);

        Buku::create([
            'judul'    => $request->judul,
            'penulis'  => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun'    => $request->tahun,
            'isbn'     => $request->isbn,
            'kategori' => $request->kategori,
            'status'   => 'tersedia', 
        ]);

        return redirect()->route('admin.buku.dashboard')->with('success', 'Buku berhasil ditambahkan!');
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
        ]);

        $buku->update($request->only(['judul', 'penulis', 'penerbit', 'tahun', 'isbn', 'kategori']));

        $this->updateStatusBuku($buku->id);

        return redirect()->route('admin.buku.dashboard')->with('success', 'Data buku berhasil diperbarui');
    }

    // Hapus buku 
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('admin.buku.dashboard')->with('success', 'Buku berhasil dihapus!');
    }

    // Helper untuk update status buku berdasarkan peminjaman aktif
    private function updateStatusBuku($bukuId)
    {
        $buku = Buku::find($bukuId);
        if (!$buku) return;

        $sedangDipinjam = Pinjam::where('buku_id', $bukuId)
                                ->where('status', 'pinjam')
                                ->exists();

        $buku->status = $sedangDipinjam ? 'dipinjam' : 'tersedia';
        $buku->save();
    }
}