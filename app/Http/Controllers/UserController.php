<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\ProgramKeahlian;
use App\Models\SatuanPendidikan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['satuanPendidikan', 'grantedDeviceUsers'])
            ->withCount([
                'alurTujuanPembelajarans',
                'modulAjars',
                'lkpds',
                'programTahunans',
                'programSemesters',
                'asesmens',
            ]);

        // Filter 1: Mata Pelajaran
        if ($request->filled('mapel')) {
            $query->where('mata_pelajaran_diampu', 'LIKE', '%' . trim($request->mapel) . '%');
        }

        // Filter 2: Jurusan / Program Keahlian
        if ($request->filled('jurusan')) {
            $query->where('jurusan', 'LIKE', '%' . trim($request->jurusan) . '%');
        }

        // Filter 3: Nama Satuan Pendidikan (Sekolah)
        if ($request->filled('satuan_pendidikan_id')) {
            $query->where('satuan_pendidikan_id', $request->satuan_pendidikan_id);
        }

        // Filter 4: Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter 5: Kata Kunci (Nama / Email / NIP)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('nip', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->latest()->get();

        // Data opsi untuk dropdown filter
        $sekolahs = SatuanPendidikan::orderBy('nama')->get();

        $userMapels = User::whereNotNull('mata_pelajaran_diampu')->where('mata_pelajaran_diampu', '!=', '')->distinct()->pluck('mata_pelajaran_diampu');
        $allMapels = MataPelajaran::where('is_active', true)->pluck('nama')->merge($userMapels)->unique()->filter()->sort()->values();

        $userJurusans = User::whereNotNull('jurusan')->where('jurusan', '!=', '')->distinct()->pluck('jurusan');
        $allJurusans = ProgramKeahlian::pluck('nama')->merge($userJurusans)->unique()->filter()->sort()->values();

        // List semua guru untuk pilihan izin akses perangkat
        $allGurus = User::where('role', 'guru')->orderBy('name')->get();

        return view('users.index', compact(
            'users',
            'sekolahs',
            'allMapels',
            'allJurusans',
            'allGurus'
        ));
    }

    public function create()
    {
        $sekolahs = SatuanPendidikan::where('is_active', true)->get();
        return view('users.create', compact('sekolahs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', Rule::in(['superadmin', 'admin_sekolah', 'guru'])],
            'nip' => ['nullable', 'string', 'max:50'],
            'mata_pelajaran_diampu' => ['nullable', 'string', 'max:255'],
            'jurusan' => ['nullable', 'string', 'max:255'],
            'satuan_pendidikan_id' => ['nullable', 'exists:satuan_pendidikans,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active');

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $sekolahs = SatuanPendidikan::where('is_active', true)->get();
        return view('users.edit', compact('user', 'sekolahs'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', Rule::in(['superadmin', 'admin_sekolah', 'guru'])],
            'nip' => ['nullable', 'string', 'max:50'],
            'mata_pelajaran_diampu' => ['nullable', 'string', 'max:255'],
            'jurusan' => ['nullable', 'string', 'max:255'],
            'satuan_pendidikan_id' => ['nullable', 'exists:satuan_pendidikans,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->has('is_active');

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function updateDeviceAccess(Request $request, User $user)
    {
        $request->validate([
            'can_view_all_devices' => ['nullable'],
            'granted_user_ids' => ['nullable', 'array'],
            'granted_user_ids.*' => ['exists:users,id'],
        ]);

        $canViewAll = $request->has('can_view_all_devices');
        $user->update([
            'can_view_all_devices' => $canViewAll,
        ]);

        $grantedUserIds = $request->input('granted_user_ids', []);
        $user->grantedDeviceUsers()->sync($grantedUserIds);

        return redirect()->route('users.index')->with('success', "Hak akses melihat perangkat untuk guru {$user->name} berhasil diperbarui.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
