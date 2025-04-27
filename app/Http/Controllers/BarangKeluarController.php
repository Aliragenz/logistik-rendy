<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluar = BarangKeluar::with('barang')->get();
        $barang= Barang::all();
        return view('barang_keluar.index', compact('barangKeluar', 'barang'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('barang_keluar.create', compact('barang'));
    }

    private function generateNoBarangKeluar()
    {
        // Get the last 'no_barang_masuk' from the database to get the last number
        $lastBarangKeluar = BarangKeluar::latest('id')->first();
        $year = date('Y');
        $prefix = 'BK-' . $year . '-';

        if (!$lastBarangKeluar) {
            return $prefix . '001'; // First entry
        }

        // Extract the sequential number from the last 'no_barang_masuk' and increment it
        preg_match('/BM-' . $year . '-(\d+)/', $lastBarangKeluar->no_barang_keluar, $matches);

        if ($matches) {
            $lastNumber = (int) $matches[1];
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            return $prefix . $nextNumber;
        }

        return $prefix . '001'; // Default to 001 if the format doesn't match
    }

    public function store(Request $request)
{
    // Auto-generate no_barang_keluar
    $noBarangKeluar = $this->generateNoBarangKeluar();

    // Validate the incoming request
    $request->validate([
        'barang_id' => 'required',
        'tanggal_keluar' => 'required|date',
        'destination' => 'required',
        'quantity' => 'required|numeric|min:1',
    ]);

    // Find the barang
    $barang = Barang::find($request->barang_id);

    // Check if the stock is sufficient
    if ($barang->stok < $request->quantity) {
        // If not enough stock, return with an error message
        return back()->with('error', 'Stok barang tidak cukup!');
    }

    // Create the BarangKeluar record with generated no_barang_keluar
    $barangKeluar = new BarangKeluar([
        'barang_id' => $request->barang_id,
        'no_barang_keluar' => $noBarangKeluar,
        'tanggal_keluar' => $request->tanggal_keluar,
        'destination' => $request->destination,
        'quantity' => $request->quantity,
    ]);

    $barangKeluar->save();

    // Reduce the stock of the barang
    $barang->stok -= $request->quantity;
    $barang->save();

    // Redirect back to the Barang Keluar index with success message
    return redirect()->route('barang-keluar.index')->with('success', 'Data barang keluar berhasil ditambahkan.');
}

    public function edit(BarangKeluar $barang_keluar)
    {
        $barang = Barang::all();
        return view('barang_keluar.edit', compact('barang_keluar', 'barang'));
    }

    public function update(Request $request, BarangKeluar $barang_keluar)
    {
       //
    }

    public function destroy(BarangKeluar $barang_keluar)
    {
        $barang_keluar->delete();
        return redirect()->route('barang-keluar.index')->with('success', 'Data barang keluar berhasil dihapus.');
    }
}
