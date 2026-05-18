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
 
    // Helper untuk update status buku
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
            'buku_id'     => 'required|exists:bukus,id',
            'tgl_pinjam'  => 'required|date',
            'tgl_kembali' => 'required|date|after:tgl_pinjam',
        ]);
 
        $buku = Buku::findOrFail($data['buku_id']);
        
        // Cek apakah buku sedang dipinjam (status = 'pinjam') oleh siapapun
        $sedangDipinjam = Pinjam::where('buku_id', $buku->id)
                                ->where('status', 'pinjam')
                                ->exists();
        if ($sedangDipinjam) {
            return back()->with('error', 'Buku sedang dipinjam, tidak tersedia.')->withInput();
        }
 
        // Cek apakah member yang sama sudah meminjam buku ini (belum dikembalikan)
        $sudahPinjam = Pinjam::where('user_id', $data['user_id'])
                             ->where('buku_id', $data['buku_id'])
                             ->where('status', 'pinjam')
                             ->exists();
        if ($sudahPinjam) {
            return back()->with('error', 'Member ini sudah meminjam buku tersebut dan belum mengembalikan.')->withInput();
        }
 
        $pinjam = Pinjam::create(array_merge($data, ['status' => 'pinjam']));
        
        // Update status buku menjadi 'dipinjam'
        $this->updateStatusBuku($buku->id);
 
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
        
        // Update status buku menjadi 'tersedia' (karena tidak ada peminjaman aktif lagi)
        $this->updateStatusBuku($pinjam->buku_id);
 
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
 
        $bukuId = $pinjam->buku_id;
        $pinjam->pengembalian()->delete();
        $pinjam->delete();
 
        // Setelah menghapus data peminjaman (status sudah 'kembali'), update status buku
        $this->updateStatusBuku($bukuId);
 
        return back()->with('success', 'Data peminjaman berhasil dihapus.');
    }
 
    public function approve($id): RedirectResponse
    {
        $pinjam = Pinjam::findOrFail($id);
 
        if ($pinjam->status !== 'pending') {
            return back()->with('error', 'Hanya peminjaman berstatus pending yang bisa disetujui.');
        }
 
        // Cek apakah buku masih tersedia (tidak ada peminjaman aktif)
        $buku = $pinjam->buku;
        $sedangDipinjam = Pinjam::where('buku_id', $buku->id)
                                ->where('status', 'pinjam')
                                ->exists();
        if ($sedangDipinjam) {
            return back()->with('error', 'Buku sudah dipinjam oleh orang lain, tidak bisa disetujui.');
        }
 
        $pinjam->update(['status' => 'pinjam']);
        $this->updateStatusBuku($buku->id);
        return back()->with('success', "Peminjaman {$pinjam->user->nama} disetujui.");
    }
 
    public function reject($id): RedirectResponse
    {
        $pinjam = Pinjam::findOrFail($id);
 
        if ($pinjam->status !== 'pending') {
            return back()->with('error', 'Hanya peminjaman berstatus pending yang bisa ditolak.');
        }
 
        $pinjam->update(['status' => 'ditolak']);
        // Status buku tidak berubah karena belum benar-benar dipinjam
        return back()->with('success', "Peminjaman {$pinjam->user->nama} ditolak.");
    }
}