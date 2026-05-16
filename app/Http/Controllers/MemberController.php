<?php

namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
 
class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::where('role', 'member')->with('pinjam');
 
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($sub) use ($q) {
                $sub->where('nama',    'like', "%{$q}%")
                    ->orWhere('email',   'like', "%{$q}%")
                    ->orWhere('telepon', 'like', "%{$q}%");
            });
        }
 
        $member      = $query->latest()->paginate(10)->withQueryString();
        $totalMember = User::where('role', 'member')->count();
        $totalAktif   = User::where('role', 'member')
                            ->whereHas('pinjam', fn($p) => $p->where('status', 'pinjam'))
                            ->count();
        $totalDenda   = \App\Models\Pengembalian::where('denda', '>', 0)->count();
 
        return view('admin.member.index', compact(
            'member', 'totalMember', 'totalAktif', 'totalDenda'
        ));
    }
 
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'telepon'               => 'nullable|string|max:20',
            'alamat'                => 'nullable|string|max:500',
            'password'              => 'required|string|min:8|confirmed',
        ]);
 
        User::create([
            'nama'     => $data['nama'],
            'email'    => $data['email'],
            'telepon'  => $data['telepon'] ?? null,
            'alamat'   => $data['alamat']  ?? null,
            'password' => Hash::make($data['password']),
            'role'    => 'member',
        ]);
 
        return back()->with('success', 'Member berhasil ditambahkan.');
    }
 
    public function update(Request $request, $id): RedirectResponse
    {
        $member = User::where('role', 'member')->findOrFail($id);
 
        $data = $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'telepon'  => 'nullable|string|max:20',
            'alamat'   => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8',
        ]);
 
        $update = [
            'nama'    => $data['nama'],
            'email'   => $data['email'],
            'telepon' => $data['telepon'] ?? null,
            'alamat'  => $data['alamat']  ?? null,
        ];
 
        if (!empty($data['password'])) {
            $update['password'] = Hash::make($data['password']);
        }
 
        $member->update($update);
 
        return back()->with('success', 'Data member berhasil diperbarui.');
    }
 
    public function destroy($id): RedirectResponse
    {
        $member = User::where('role', 'member')->findOrFail($id);
 
        foreach ($member->pinjam as $p) {
            $p->pengembalian()->delete();
            $p->delete();
        }
 
        $member->delete();
 
        return back()->with('success', 'Member berhasil dihapus.');
    }
}