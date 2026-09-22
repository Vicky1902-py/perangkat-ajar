<?php

namespace App\Http\Controllers;

use App\Models\SatuanPendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Tampilkan formulir pengaturan profil dan identitas sekolah.
     */
    public function setup()
    {
        $user = Auth::user()->load('satuanPendidikan');
        $sekolah = $user->satuanPendidikan ?? new SatuanPendidikan();

        return view('profile.setup', compact('user', 'sekolah'));
    }

    /**
     * Simpan pembaruan profil pengguna dan data sekolah.
     */
    public function save(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            // Data Pribadi Guru
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:35',
            'telepon' => 'nullable|string|max:30',
            'mata_pelajaran_diampu' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',

            // Data Satuan Pendidikan (Sekolah)
            'nama_sekolah' => 'required|string|max:255',
            'npsn' => 'required|string|max:20',
            'jenjang' => 'required|in:SD,SMP,SMA,SMK',
            'alamat' => 'nullable|string',
            'kota' => 'required|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'telepon_sekolah' => 'nullable|string|max:50',
            'email_sekolah' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',

            // Pejabat Penandatangan
            'kepala_sekolah' => 'required|string|max:255',
            'nip_kepala_sekolah' => 'required|string|max:35',

            // Pengaturan Kop Surat Kedinasan
            'dinas_pendidikan' => 'nullable|string|max:255',
            'kop_baris_1' => 'nullable|string|max:255',
            'kop_baris_2' => 'nullable|string|max:255',
            'kop_baris_3' => 'nullable|string|max:255',
            'kop_baris_4' => 'nullable|string|max:255',
            'ukuran_kertas_default' => 'nullable|in:A4,F4',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ], [
            'name.required' => 'Nama lengkap guru wajib diisi.',
            'nama_sekolah.required' => 'Nama sekolah / satuan pendidikan wajib diisi.',
            'npsn.required' => 'Nomor Pokok Sekolah Nasional (NPSN) wajib diisi.',
            'kota.required' => 'Kota/Kabupaten sekolah wajib diisi untuk titimangsa dokumen.',
            'kepala_sekolah.required' => 'Nama Kepala Sekolah wajib diisi untuk form tanda tangan.',
            'nip_kepala_sekolah.required' => 'NIP Kepala Sekolah wajib diisi.',
            'logo.max' => 'Ukuran file logo maksimal 2MB.',
            'logo.image' => 'File logo harus berupa format gambar yang valid (PNG, JPG, SVG).',
        ]);

        // Simpan / Perbarui Satuan Pendidikan
        if ($user->satuan_pendidikan_id) {
            $sekolah = SatuanPendidikan::find($user->satuan_pendidikan_id) ?? new SatuanPendidikan();
        } else {
            $sekolah = new SatuanPendidikan();
        }

        $sekolah->nama = $validated['nama_sekolah'];
        $sekolah->npsn = $validated['npsn'];
        $sekolah->jenjang = $validated['jenjang'];
        $sekolah->alamat = $validated['alamat'] ?? null;
        $sekolah->kota = $validated['kota'];
        $sekolah->provinsi = $validated['provinsi'] ?? null;
        $sekolah->telepon = $validated['telepon_sekolah'] ?? null;
        $sekolah->email = $validated['email_sekolah'] ?? null;
        $sekolah->website = $validated['website'] ?? null;
        $sekolah->kepala_sekolah = $validated['kepala_sekolah'];
        $sekolah->nip_kepala_sekolah = $validated['nip_kepala_sekolah'];
        $sekolah->dinas_pendidikan = $validated['dinas_pendidikan'] ?? ($validated['kop_baris_2'] ?? 'DINAS PENDIDIKAN');
        $sekolah->ukuran_kertas_default = $validated['ukuran_kertas_default'] ?? 'A4';

        // 4 Baris Kop Surat Resmi:
        // Baris 1: Pemerintah Daerah (PEMERINTAH PROVINSI ...)
        // Baris 2: Dinas Pendidikan (DINAS PENDIDIKAN DAN KEBUDAYAAN)
        // Baris 3: Nama Satuan Pendidikan (SMK NEGERI ...)
        // Baris 4: Alamat, Telepon, Email, NPSN, Website
        $sekolah->kop_baris_1 = ($validated['kop_baris_1'] ?? null) ?: ('PEMERINTAH PROVINSI ' . strtoupper($validated['provinsi'] ?? 'DKI JAKARTA'));
        $sekolah->kop_baris_2 = ($validated['kop_baris_2'] ?? null) ?: (($validated['dinas_pendidikan'] ?? null) ?: 'DINAS PENDIDIKAN DAN KEBUDAYAAN');
        $sekolah->kop_baris_3 = ($validated['kop_baris_3'] ?? null) ?: strtoupper($validated['nama_sekolah']);
        $sekolah->kop_baris_4 = ($validated['kop_baris_4'] ?? null) ?: trim(($validated['alamat'] ?? '') . ' | Telp: ' . ($validated['telepon_sekolah'] ?? '-') . ' | NPSN: ' . $validated['npsn'], ' |');

        // Upload Logo jika ada
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($sekolah->logo && Storage::disk('public')->exists($sekolah->logo)) {
                Storage::disk('public')->delete($sekolah->logo);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $sekolah->logo = $path;
        }

        $sekolah->save();

        // Perbarui Data User
        $user->name = $validated['name'];
        $user->nip = $validated['nip'] ?? null;
        $user->telepon = $validated['telepon'] ?? null;
        $user->mata_pelajaran_diampu = $validated['mata_pelajaran_diampu'] ?? null;
        $user->jurusan = $validated['jurusan'] ?? null;
        $user->satuan_pendidikan_id = $sekolah->id;
        $user->is_profile_completed = true;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Data profil pribadi dan instansi sekolah berhasil diperbarui! Seluruh ekspor dokumen (ATP, Modul Ajar, LKPD, Asesmen) kini telah menggunakan Kop Surat resmi dan Form Tanda Tangan sekolah Anda.');
    }
}
