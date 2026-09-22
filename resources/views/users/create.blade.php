@extends('layouts.app')

@section('title', 'Tambah Pengguna Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <a href="{{ route('users.index') }}" class="text-secondary small text-decoration-none mb-1 d-inline-block">
                    <i class="bi bi-arrow-left"></i> Kembali ke Manajemen Pengguna
                </a>
                <h4 class="fw-bold text-dark mb-0">Tambah Pengguna Baru</h4>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold small">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso, M.Kom.">
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold small">Alamat Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@sekolah.sch.id">
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold small">Kata Sandi Awal <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Minimal 6 karakter">
                        </div>

                        <div class="col-md-6">
                            <label for="role" class="form-label fw-semibold small">Peran Akun (Role) <span class="text-danger">*</span></label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="guru" selected>Guru Pengampu</option>
                                <option value="admin_sekolah">Admin Sekolah</option>
                                <option value="superadmin">Super Administrator (Akses Penuh)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="nip" class="form-label fw-semibold small">NIP / NUPTK</label>
                            <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip') }}" placeholder="18 digit NIP atau kosongkan">
                        </div>

                        <div class="col-md-6">
                            <label for="satuan_pendidikan_id" class="form-label fw-semibold small">Satuan Pendidikan (Sekolah)</label>
                            <select class="form-select" id="satuan_pendidikan_id" name="satuan_pendidikan_id">
                                <option value="">-- Pilih Satuan Pendidikan --</option>
                                @foreach($sekolahs as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }} (NPSN: {{ $s->npsn }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                <label class="form-check-label fw-semibold small" for="is_active">Aktifkan akun ini sekarang</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{ route('users.index') }}" class="btn btn-light border rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Pengguna</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
