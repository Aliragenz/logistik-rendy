@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Barang Keluar</h1>

    <!-- Button to trigger the modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#barangKeluarModal">
        Tambah Barang Keluar
    </button>

    <!-- Messages -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Modal for "Tambah Barang Keluar" -->
    <div class="modal fade" id="barangKeluarModal" tabindex="-1" aria-labelledby="barangKeluarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barangKeluarModalLabel">Input Barang Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('barang-keluar.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label>Barang</label><br>
                            <select name="barang_id" id="barangSelect" class="form-control" required>
                                <option value="">Pilih Barang</option>
                                @foreach ($barang as $b)
                                    <option value="{{ $b->id }}" data-stok="{{ $b->stok }}">{{ $b->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal Keluar</label><br>
                            <input type="date" name="tanggal_keluar" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Stok Tersisa</label><br>
                            <input type="text" id="sisaStok" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label>Quantity</label>
                            <input type="number" name="quantity" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Destination</label>
                            <input type="text" name="destination" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>

                    <script>
                        // When the user selects a barang, update the stock information
                        document.getElementById('barangSelect').addEventListener('change', function() {
                            // Get selected option
                            var selectedOption = this.options[this.selectedIndex];
                            // Get the stock value from the data attribute
                            var stokLeft = selectedOption.getAttribute('data-stok');
                            // Display the stock left in the input field
                            document.getElementById('sisaStok').value = stokLeft;
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Keluar List -->
    <table class="table table-bordered text-custom-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang Keluar</th>
                <th>Nama Barang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangKeluar as $keluar)
            <tr data-bs-toggle="modal" data-bs-target="#detailModal"
                data-bs-kode="{{ $keluar->no_barang_keluar }}"
                data-bs-nama="{{ $keluar->barang->nama_barang }}"
                data-bs-quantity="{{ $keluar->quantity }}"
                data-bs-tanggal="{{ $keluar->tanggal_keluar }}"
                data-bs-destination="{{ $keluar->destination }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $keluar->no_barang_keluar }}</td>
                <td>{{ $keluar->barang->nama_barang }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal for Detail Barang Keluar -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Barang Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Kode Barang Keluar:</strong> <span id="detailKode"></span></p>
                <p><strong>Nama Barang:</strong> <span id="detailNama"></span></p>
                <p><strong>Jumlah Keluar:</strong> <span id="detailQuantity"></span> pcs</p>
                <p><strong>Tanggal Keluar:</strong> <span id="detailTanggal"></span></p>
                <p><strong>Tujuan:</strong> <span id="detailDestination"></span></p>
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
        const destination = button.getAttribute('data-bs-destination');

        // Update the modal's content
        document.getElementById('detailKode').textContent = kode;
        document.getElementById('detailNama').textContent = nama;
        document.getElementById('detailQuantity').textContent = quantity;
        document.getElementById('detailTanggal').textContent = tanggal;
        document.getElementById('detailDestination').textContent = destination;
    });
</script>

@endsection
