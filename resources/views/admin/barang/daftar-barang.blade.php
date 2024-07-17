@extends('layout.app')

@section('title', 'Daftar Barang')

@section('content')
    <section class="section">
        <!--Header-->
        <div class="section-header">
            <h1>Daftar Barang</h1>
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
                                <!--Tombol Tambah Barang-->
                                <div class="float-left">
                                    <a href="{{ route('barang.create') }}" class="btn btn-primary btn-lg">Tambah Barang</a>
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
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Lokasi Barang</th>
                                        <th>Kondisi Barang</th>
                                        <th>Keterangan</th>
                                        @can('admin-only')
                                            <th>Aksi</th>
                                        @endcan
                                    </tr>

                                    @forelse ($daftarBarang as $index => $barang)
                                        <tr>
                                            <td>
                                                {{ $index + $daftarBarang->firstItem() }}
                                            </td>
                                            <td>
                                                <span class="badge badge-light">{{ $barang->kode_barang }}</span>
                                            </td>
                                            <td>
                                                {{ $barang->nama_barang }}
                                            </td>
                                            <td>
                                                {{ $barang->lokasi_barang }}
                                            </td>
                                            <td>
                                                @if ($barang->kondisi_barang == 'bagus')
                                                    <span class="badge badge-success">Bagus</span>
                                                @elseif ($barang->kondisi_barang == 'rusak')
                                                    <span class="badge badge-danger">Rusak</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $barang->keterangan }}
                                            </td>

                                            @can('admin-only')
                                                <td>
                                                    <div class="row">
                                                        <!--Tombol Update-->
                                                        <a href="{{ route('barang.edit', $barang->id) }}"
                                                            class="btn btn-primary">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        <div style="width: 10px;"></div>

                                                        <!--Tombol Hapus-->
                                                        <form action="{{ route('barang.destroy', $barang->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" id="delete-confirm">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>
                                                        </form>
                                                        <div style="width: 10px;"></div>

                                                        <!--Ajukan Perbaikan/Pergantian Barang-->
                                                        @if ($barang->kondisi_barang == 'rusak')
                                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                                data-target="#modalAjukan">
                                                                <i class="fa-solid fa-file-arrow-up"></i>
                                                            </button>
                                                        @endif

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
                                        {{ $daftarBarang->withQueryString()->links() }}
                                    </ul>
                                </nav>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Ajukan Perbaikan/Pergantian -->
    <div class="modal fade" id="modalAjukan" tabindex="-1" role="dialog" aria-labelledby="modalAjukanTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAjukanTitle">Ajukan Perbaikan/Pergantian Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Pilih jenis pengajuan yang Anda inginkan:</p>
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-info btn-lg btn-block mb-2"
                                onclick="ajukanPengajuan('{{ $barang->id }}', 'perbaikan')">Ajukan Perbaikan</button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-primary btn-lg btn-block"
                                onclick="ajukanPengajuan('{{ $barang->id }}', 'pergantian')">Ajukan Pergantian
                                Barang</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customJs')
    <script>
        function ajukanPengajuan(barangId, jenisPengajuan) {
            // Kirim jenis pengajuan ke fungsi pengajuan() di controller
            $.ajax({
                type: 'POST',
                url: '{{ route('barang.pengajuan') }}',
                data: {
                    barang_id: barangId,
                    jenis_pengajuan: jenisPengajuan,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Handle response jika diperlukan
                    console.log(response);
                    // Sembunyikan modal setelah berhasil
                    $('#modalAjukan').modal('hide');
                },
                error: function(xhr, status, error) {
                    // Handle error jika diperlukan
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
@endpush


