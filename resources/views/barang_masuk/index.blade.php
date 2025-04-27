@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Barang Masuk</h1>

    <!-- Button to trigger the modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#barangMasukModal">
        Tambah Barang Masuk
    </button>

    <!-- Messages -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Modal for "Tambah Barang Masuk" -->
    <div class="modal fade" id="barangMasukModal" tabindex="-1" aria-labelledby="barangMasukModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barangMasukModalLabel">Input Barang Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('barang-masuk.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label>Barang</label><br>
                            <select name="barang_id" class="form-control" required>
                                <option value="">Pilih Barang</option>
                                @foreach ($barang as $b)
                                    <option value="{{ $b->id }}">{{ $b->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal Masuk</label><br>
                            <input type="date" name="tanggal_masuk" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Quantity</label>
                            <input type="number" name="quantity" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Origin</label>
                            <input type="text" name="origin" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Masuk List -->
    <table class="table table-bordered  text-custom-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang Masuk</th>
                <th>Nama Barang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangMasuk as $masuk)
            <tr data-bs-toggle="modal" data-bs-target="#detailModal"
                data-bs-kode="{{ $masuk->no_barang_masuk }}"
                data-bs-nama="{{ $masuk->barang->nama_barang }}"
                data-bs-quantity="{{ $masuk->quantity }}"
                data-bs-tanggal="{{ $masuk->tanggal_masuk }}"
                data-bs-origin="{{ $masuk->origin }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $masuk->no_barang_masuk }}</td>
                <td>{{ $masuk->barang->nama_barang }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal for Detail Barang Masuk -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Barang Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Kode Barang Masuk:</strong> <span id="detailKode"></span></p>
                <p><strong>Nama Barang:</strong> <span id="detailNama"></span></p>
                <p><strong>Jumlah Masuk:</strong> <span id="detailQuantity"></span> pcs</p>
                <p><strong>Tanggal Masuk:</strong> <span id="detailTanggal"></span></p>
                <p><strong>Asal:</strong> <span id="detailOrigin"></span></p>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript to update modal content with the clicked row data
    const detailModal = document.getElementById('detailModal');
    detailModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const kode = button.getAttribute('data-bs-kode');
        const nama = button.getAttribute('data-bs-nama');
        const quantity = button.getAttribute('data-bs-quantity');
        const tanggal = button.getAttribute('data-bs-tanggal');
        const origin = button.getAttribute('data-bs-origin');

        // Update the modal's content
        document.getElementById('detailKode').textContent = kode;
        document.getElementById('detailNama').textContent = nama;
        document.getElementById('detailQuantity').textContent = quantity;
        document.getElementById('detailTanggal').textContent = tanggal;
        document.getElementById('detailOrigin').textContent = origin;
    });
</script>

@endsection
