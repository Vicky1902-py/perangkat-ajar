@php
    $sekolah = $sekolah ?? ($model->user?->satuanPendidikan ?? auth()->user()?->satuanPendidikan ?? null);
    $guru = $guru ?? ($model->user ?? auth()->user() ?? null);
    $kota = $sekolah?->kota ?? 'Jakarta';
    $tanggalStr = \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y');
@endphp

<table style="width: 100%; margin-top: 25px; border-collapse: collapse; border: none; font-size: 9pt; page-break-inside: avoid;">
    <tr>
        <!-- SEBELAH KIRI: KEPALA SEKOLAH -->
        <td style="width: 50%; vertical-align: top; text-align: left; padding-left: 20px; border: none;">
            <div>Mengetahui,</div>
            <div style="font-weight: 600;">Kepala {{ $sekolah->nama ?? 'Sekolah' }}</div>
            <div style="height: 55px;"></div>
            <div style="font-weight: bold; text-decoration: underline; color: #000;">
                {{ $sekolah->kepala_sekolah ?? 'Drs. H. Suryadi, M.Pd.' }}
            </div>
            <div style="color: #333;">
                NIP. {{ $sekolah->nip_kepala_sekolah ?? '196805121994031005' }}
            </div>
        </td>

        <!-- SEBELAH KANAN: GURU MATA PELAJARAN -->
        <td style="width: 50%; vertical-align: top; text-align: left; padding-left: 35px; border: none;">
            <div>{{ $kota }}, {{ $tanggalStr }}</div>
            <div style="font-weight: 600;">Guru Mata Pelajaran,</div>
            <div style="height: 55px;"></div>
            <div style="font-weight: bold; text-decoration: underline; color: #000;">
                {{ $guru->name ?? 'Guru Pengampu' }}
            </div>
            <div style="color: #333;">
                NIP. {{ $guru->nip ?: '-' }}
            </div>
        </td>
    </tr>
</table>
