<?php
namespace App\Http\Controllers;
 
use App\Models\Buku;
use App\Models\Pengembalian;
use App\Models\Pinjam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
 
class PinjamController extends Controller
{
    const DENDA_PER_HARI = 2000;
 
    public function index(Request $request): View
    {
        $query = Pinjam::with(['user', 'buku', 'pengembalian'])->latest();
 
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($sub) use ($q) {
                $sub->whereHas('user', fn($u) => $u->where('nama', 'like', "%{$q}%"))
                    ->orWhereHas('buku', fn($b) => $b->where('judul', 'like', "%{$q}%"));
            });
        }
 
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
 
        $pinjam        = $query->paginate(10)->withQueryString();
        $totalPinjam   = Pinjam::count();
        $totalAktif    = Pinjam::where('status', 'pinjam')->count();
        $totalKembali  = Pinjam::where('status', 'kembali')->count();
        $totalTerlambat = Pinjam::where('status', 'pinjam')
                                 ->where('tgl_kembali', '<', now()->toDateString())
                                 ->count();
 
        // Data untuk modal tambah
        $members = User::where('role', 'member')->orderBy('nama')->get();
        $buku    = Buku::orderBy('judul')->get();
 
        return view('admin.pinjam.index', compact(
            'pinjam', 'totalPinjam', 'totalAktif',
            'totalKembali', 'totalTerlambat', 'members', 'buku'
        ));
    }
 
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id'     => 'required|exists:users,id',
            'buku_id'     => 'required|exists:buku,id',
            'tgl_pinjam'  => 'required|date',
            'tgl_kembali' => 'required|date|after:tgl_pinjam',
        ]);
 
        // Cek stok buku
        $buku = Buku::findOrFail($data['buku_id']);
        $dipinjam = Pinjam::where('buku_id', $buku->id)->where('status', 'pinjam')->count();
        if ($dipinjam >= $buku->jumlah) {
            return back()->with('error', 'Stok buku habis / semua sedang dipinjam.')->withInput();
        }
 
        // Cek member sudah pinjam buku yang sama
        $sudahPinjam = Pinjam::where('user_id', $data['user_id'])
                             ->where('buku_id', $data['buku_id'])
                             ->where('status', 'pinjam')->exists();
 
        if ($sudahPinjam) {
            return back()->with('error', 'Member ini sudah meminjam buku tersebut.')->withInput();
        }
 
        Pinjam::create(array_merge($data, ['status' => 'pinjam']));
 
        return back()->with('success', 'Peminjaman berhasil dicatat.');
    }
 
    public function kembalikan(Request $request, $id): RedirectResponse
    {
        $pinjam = Pinjam::with('pengembalian')->findOrFail($id);
 
        if ($pinjam->status === 'kembali') {
            return back()->with('error', 'Buku ini sudah pernah dikembalikan.');
        }
 
        $denda = 0;
        if (now()->gt($pinjam->tgl_kembali)) {
            $hari  = (int) now()->diffInDays($pinjam->tgl_kembali);
            $denda = $hari * self::DENDA_PER_HARI;
        }
 
        Pengembalian::create([
            'pinjam_id'   => $pinjam->id,
            'tgl_kembali' => now()->toDateString(),
            'denda'       => $denda,
        ]);
 
        $pinjam->update(['status' => 'kembali']);
 
        $pesan = $denda > 0
            ? 'Pengembalian berhasil. Denda: Rp ' . number_format($denda, 0, ',', '.')
            : 'Pengembalian berhasil. Tidak ada denda.';
 
        return back()->with('success', $pesan);
    }
 
    public function destroy($id): RedirectResponse
    {
        $pinjam = Pinjam::findOrFail($id);
 
        if ($pinjam->status === 'pinjam') {
            return back()->with('error', 'Tidak bisa hapus peminjaman yang masih aktif.');
        }
 
        $pinjam->pengembalian()->delete();
        $pinjam->delete();
 
        return back()->with('success', 'Data peminjaman berhasil dihapus.');
    }
}