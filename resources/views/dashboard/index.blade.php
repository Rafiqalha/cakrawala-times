@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    @php
                        $foto = Auth::user()->foto ? Auth::user()->foto : 'default.png';
                    @endphp
                    <img src="{{ asset('storage/foto/' . $foto) }}"
                         alt="Foto Profil"
                         class="rounded-circle mb-3"
                         width="80" height="80">
                    <h5 class="card-title">Selamat datang, {{ Auth::user()->nama_lengkap }}</h5>
                    <p class="text-muted mb-1">Waktu Login:</p>
                    <p class="fw-bold">{{ $loginTime }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
