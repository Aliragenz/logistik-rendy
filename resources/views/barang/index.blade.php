@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Barang</h1>

    <!-- Button to trigger the modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#barangModal">
        Tambah Barang
    </button>

    <!-- Messages -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Table for displaying barang -->
    <div class="table-responsive">
        <table class="table table-bordered  text-custom-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangs as $b)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $b->kode_barang }}</td>
                        <td>{{ $b->nama_barang }}</td>
                        <td>{{ $b->stok }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada barang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for adding barang -->
<div class="modal fade" id="barangModal" tabindex="-1" aria-labelledby="barangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="barangModalLabel">Tambah Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('barang.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
