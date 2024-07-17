@extends('layout.app')

@section('title', 'Daftar Jadwal Jaga Sistem')

@section('content')
    <section class="section">
        <!--Header-->
        <div class="section-header">
            <h1>Daftar Jadwal Jaga Sistem</h1>
        </div>

        <!--Body-->
        <div class="section-body">
            @include('layout.alert-notif')

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <!--Tombol-->
                            @can('admin-only')
                                <!--Tombol Tambah Jadwal Jaga-->
                                <div class="float-left">
                                    <a href="{{ route('jadwal.create') }}" class="btn btn-primary btn-lg">Tambah Jadwal Jaga</a>
                                </div>
                            @endcan

                            <!--Pencarian-->
                            <div class="float-right">
                                <form method="GET">
                                    <div class="input-group">
                                        <input name="search" type="text" class="form-control" placeholder="Search">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!--Spacer-->
                            <div class="clearfix mb-3"></div>

                            <!--Tabel-->
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Hari Bertugas</th>
                                        <th>Aksi</th>
                                    </tr>

                                    @forelse ($jadwalJaga as $index => $jadwal)
                                        <tr>
                                            <td>
                                                {{ $index + $jadwalJaga->firstItem() }}
                                            </td>
                                            <td>
                                                {{ $jadwal->pengguna->nama }}
                                            </td>
                                            <td>
                                                {{ implode(', ', $jadwal->hari) }}
                                            </td>
                                            @can('admin-only')
                                                <td>
                                                    <div class="row">
                                                        <!--Tombol Update-->
                                                        <a href="{{ route('jadwal.edit', $jadwal->id) }}"
                                                            class="btn btn-primary" data-toggle="tooltip"
                                                            data-original-title="Edit Jadwal">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        <div style="width: 10px;"></div>

                                                        <!--Tombol Hapus-->
                                                        <form
                                                            action="{{ route('jadwal.destroy', $jadwal->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" id="delete-confirm"
                                                                data-toggle="tooltip" data-original-title="Hapus Jadwal">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            @endcan
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>Data Tidak Ditemukan</td>
                                        </tr>
                                    @endforelse

                                </table>
                            </div>

                            <!--Navigasi Halaman-->
                            <div class="float-right">
                                <nav>
                                    <ul class="pagination">
                                        {{ $jadwalJaga->withQueryString()->links() }}
                                    </ul>
                                </nav>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection