@extends('layout.app')

@section('title', 'Beranda')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Beranda</h1>
        </div>

        <div class="section-body">
            <!--Card Welcome User-->
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="hero bg-primary text-white">
                        <div class="hero-inner">
                            {{-- Menampilkan pesan selamat datang sesuai dengan peran pengguna --}}
                            @php
                                $user = auth()->user();
                                $name = $user->name;
                                if ($user->role === 'admin') {
                                    $role = 'Admin';
                                } else {
                                    $role = 'Beranda';
                                }
                            @endphp
                            <h2>Halo, {{ $name }}</h2>
                            <p class="lead">Selamat datang di halaman {{ $role }}!</p>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="row">
            <img src="{{ asset('assets/img/uncp.png') }}" height="450" alt="" srcset="">
        </div>
    </section>
@endsection
