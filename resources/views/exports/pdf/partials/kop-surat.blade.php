@php
    $sekolah = $sekolah ?? ($model->user?->satuanPendidikan ?? auth()->user()?->satuanPendidikan ?? null);
    
    $baris1 = $sekolah?->kop_baris_1 ?? 'PEMERINTAH PROVINSI NUSA TENGGARA TIMUR';

    if (!empty($sekolah?->kop_baris_4)) {
        $baris2 = $sekolah->kop_baris_2 ?? 'DINAS PENDIDIKAN DAN KEBUDAYAAN';
        $baris3 = $sekolah->kop_baris_3 ?? strtoupper($sekolah->nama ?? 'SMKN 1 KUPANG BARAT');
        $baris4 = $sekolah->kop_baris_4;
    } else {
        $baris2 = $sekolah?->dinas_pendidikan ?: 'DINAS PENDIDIKAN DAN KEBUDAYAAN';
        $baris3 = $sekolah?->kop_baris_2 ?: strtoupper($sekolah?->nama ?? 'SMKN 1 KUPANG BARAT');
        $baris4 = $sekolah?->kop_baris_3 ?: trim(($sekolah?->alamat ?? '') . ' | Telp: ' . ($sekolah?->telepon ?? '-') . ' | NPSN: ' . ($sekolah?->npsn ?? '-'), ' |');
    }

    $logoBase64 = $sekolah ? $sekolah->logo_base64 : null;
@endphp

<div style="width: 100%; border-bottom: 3px double #000000; padding-bottom: 5px; margin-bottom: 12px;">
    <table style="width: 100%; border-collapse: collapse; border: none;">
        <tr>
            <td style="width: 13%; text-align: center; vertical-align: middle; border: none; padding: 0 6px 0 0;">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" style="max-height: 65px; max-width: 75px; object-fit: contain;">
                @else
                    <!-- Emblem Resmi Pendidikan Standar -->
                    <div style="display: inline-block; width: 56px; height: 56px; border: 2px solid #1e3c72; border-radius: 50%; text-align: center; line-height: 13px; padding-top: 13px; box-sizing: border-box;">
                        <span style="font-size: 7.5pt; font-weight: bold; color: #1e3c72; display: block;">SMK</span>
                        <span style="font-size: 5.5pt; color: #1e3c72; display: block;">BISA</span>
                    </div>
                @endif
            </td>
            <td style="width: 87%; text-align: center; vertical-align: middle; border: none; padding: 0;">
                <div style="font-size: 9.5pt; font-weight: bold; text-transform: uppercase; color: #111827; letter-spacing: 0.5px; line-height: 1.15;">
                    {{ $baris1 }}
                </div>
                <div style="font-size: 10.5pt; font-weight: bold; text-transform: uppercase; color: #111827; letter-spacing: 0.5px; line-height: 1.2; margin: 1px 0;">
                    {{ $baris2 }}
                </div>
                <div style="font-size: 13pt; font-weight: 800; text-transform: uppercase; color: #000000; letter-spacing: 1px; margin: 2px 0; line-height: 1.25;">
                    {{ $baris3 }}
                </div>
                <div style="font-size: 7.5pt; color: #374151; line-height: 1.2;">
                    {{ $baris4 }}
                </div>
            </td>
        </tr>
    </table>
</div>
