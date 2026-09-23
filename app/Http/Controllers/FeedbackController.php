<?php

namespace App\Http\Controllers;

use App\Models\UserFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Kirim usul, saran, atau masukan (Publik / User).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:120',
            'email' => 'nullable|email|max:150',
            'no_hp' => 'nullable|string|max:40',
            'kategori' => 'required|in:usul_fitur,perbaikan_kekurangan,laporan_bug,pertanyaan,apresiasi,lainnya',
            'rating' => 'required|integer|min:1|max:5',
            'judul' => 'required|string|max:200',
            'pesan' => 'required|string|max:4000',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'kategori.required' => 'Silakan pilih kategori masukan.',
            'judul.required' => 'Judul usulan / saran wajib diisi.',
            'pesan.required' => 'Mohon jelaskan usul, saran, atau apa yang dirasa kurang.',
        ]);

        // Deteksi jenis perangkat
        $userAgent = $request->userAgent() ?? '';
        $deviceType = 'Desktop / Laptop';
        if (preg_match('/(ipad|tablet|(android(?!.*mobile))|(windows(?!.*phone)(.*touch))|kindle|playbook|silk|(puffin(?!.*(IP|AP|WP))))/i', $userAgent)) {
            $deviceType = 'Tablet';
        } elseif (preg_match('/(mobi|ipod|phone|blackberry|opera mini|fennec|minimo|symbian|psp|nintendo ds)/i', $userAgent)) {
            $deviceType = 'Smartphone';
        }

        $feedback = UserFeedback::create([
            'user_id' => Auth::id(),
            'nama' => $validated['nama'],
            'email' => $validated['email'] ?? (Auth::user()?->email),
            'no_hp' => $validated['no_hp'] ?? null,
            'kategori' => $validated['kategori'],
            'rating' => $validated['rating'],
            'judul' => $validated['judul'],
            'pesan' => $validated['pesan'],
            'status' => 'baru',
            'ip_address' => $request->ip(),
            'device_type' => $deviceType,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Terima kasih banyak! Usul dan masukan Anda telah terkirim dan langsung diterima oleh Superadmin.',
                'data' => $feedback,
            ]);
        }

        return back()->with('success', 'Terima kasih banyak! Usul dan masukan Anda telah langsung diteruskan ke dasbor Superadmin.');
    }

    /**
     * Tampilkan daftar usul & saran di panel Superadmin.
     */
    public function index(Request $request)
    {
        $query = UserFeedback::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('pesan', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $feedbacks = $query->paginate(15)->withQueryString();

        $metrics = [
            'total' => UserFeedback::count(),
            'baru' => UserFeedback::where('status', 'baru')->count(),
            'ditinjau' => UserFeedback::where('status', 'ditinjau')->count(),
            'diterapkan' => UserFeedback::where('status', 'diterapkan')->count(),
            'avg_rating' => round(UserFeedback::avg('rating') ?? 5, 1),
        ];

        return view('cms.feedbacks.index', compact('feedbacks', 'metrics'));
    }

    /**
     * Perbarui status dan catatan tindak lanjut admin.
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:baru,ditinjau,diterapkan,selesai',
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        $feedback = UserFeedback::findOrFail($id);
        $feedback->update($validated);

        return redirect()->route('cms.feedbacks.index')
            ->with('success', "Status masukan '{$feedback->judul}' berhasil diubah menjadi: " . ucfirst($feedback->status));
    }

    /**
     * Hapus usul & saran.
     */
    public function destroy($id)
    {
        $feedback = UserFeedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('cms.feedbacks.index')
            ->with('success', 'Usul/saran berhasil dihapus dari sistem.');
    }
}
