<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AlurTujuanPembelajaran;
use App\Models\Asesmen;
use App\Models\GuestUsage;
use App\Models\Lkpd;
use App\Models\ModulAjar;
use App\Models\ProgramSemester;
use App\Models\ProgramTahunan;
use App\Models\TujuanPembelajaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nip' => ['nullable', 'string', 'max:35'],
            'mata_pelajaran_diampu' => ['nullable', 'string', 'max:255'],
            'jurusan' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain atau masuk.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'guru',
            'nip' => $validated['nip'] ?? null,
            'mata_pelajaran_diampu' => $validated['mata_pelajaran_diampu'] ?? null,
            'jurusan' => $validated['jurusan'] ?? null,
            'is_active' => true,
            'is_profile_completed' => false,
            'can_view_all_devices' => false,
        ]);

        // Transfer perangkat yang sebelumnya dibuat pada sesi tamu ke akun baru ini
        $guestSessionId = $request->session()->get('guest_session_id', $request->session()->getId());
        $ip = $request->ip();

        $guestSessionIds = array_filter([$guestSessionId, session()->getId()]);
        $guestUsage = GuestUsage::where('session_id', $guestSessionId)
            ->orWhere('ip_address', $ip)
            ->first();
        if ($guestUsage && !empty($guestUsage->session_id)) {
            $guestSessionIds[] = $guestUsage->session_id;
        }
        $guestSessionIds = array_values(array_unique($guestSessionIds));

        if (!empty($guestSessionIds)) {
            AlurTujuanPembelajaran::whereIn('guest_session_id', $guestSessionIds)->update(['user_id' => $user->id, 'guest_session_id' => null]);
            ModulAjar::whereIn('guest_session_id', $guestSessionIds)->update(['user_id' => $user->id, 'guest_session_id' => null]);
            Lkpd::whereIn('guest_session_id', $guestSessionIds)->update(['user_id' => $user->id, 'guest_session_id' => null]);
            ProgramTahunan::whereIn('guest_session_id', $guestSessionIds)->update(['user_id' => $user->id, 'guest_session_id' => null]);
            ProgramSemester::whereIn('guest_session_id', $guestSessionIds)->update(['user_id' => $user->id, 'guest_session_id' => null]);
            Asesmen::whereIn('guest_session_id', $guestSessionIds)->update(['user_id' => $user->id, 'guest_session_id' => null]);
            TujuanPembelajaran::whereIn('guest_session_id', $guestSessionIds)->update(['user_id' => $user->id, 'guest_session_id' => null]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('profile.setup')->with('success', 'Pendaftaran akun berhasil! Silakan lengkapi profil sekolah dan identitas Anda untuk mencetak Kop Surat kedinasan dan Tanda Tangan resmi.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda sedang dinonaktifkan oleh administrator.',
                ]);
            }

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}
