<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $barangMasuk = BarangMasuk::with('barang')->get();
        $barang= Barang::all();
        return view('barang_masuk.index', compact('barangMasuk', 'barang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barang = Barang::all();
        return view('barang_masuk.create', compact('barang'));
    }

    private function generateNoBarangMasuk()
    {
        // Get the last 'no_barang_masuk' from the database to get the last number
        $lastBarangMasuk = BarangMasuk::latest('id')->first();
        $year = date('Y');
        $prefix = 'BM-' . $year . '-';

        if (!$lastBarangMasuk) {
            return $prefix . '001'; // First entry
        }

        // Extract the sequential number from the last 'no_barang_masuk' and increment it
        preg_match('/BM-' . $year . '-(\d+)/', $lastBarangMasuk->no_barang_masuk, $matches);

        if ($matches) {
            $lastNumber = (int) $matches[1];
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            return $prefix . $nextNumber;
        }

        return $prefix . '001'; // Default to 001 if the format doesn't match
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $noBarangMasuk = $this->generateNoBarangMasuk();
        $request->validate([
            'barang_id' => 'required',
            'tanggal_masuk' => 'required|date',
            'origin' => 'required',
            'quantity' => 'required|numeric',
        ]);

        $barangMasuk = new BarangMasuk([
            'barang_id' => $request->barang_id,
            'no_barang_masuk' => $noBarangMasuk,
            'tanggal_masuk' => $request->tanggal_masuk,
            'origin' => $request->origin,
            'quantity' => $request->quantity,
        ]);

        $barangMasuk->save();

        // Update stok barang
        $barang = Barang::find($request->barang_id);
        $barang->stok += $request->quantity;
        $barang->save();

        return redirect()->route('barang-masuk.index')->with('success', 'Data barang masuk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BarangMasuk $barang_masuk)
    {
        $barang = Barang::all();
        return view('barang_masuk.edit', compact('barang_masuk', 'barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BarangMasuk $barang_masuk)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangMasuk $barang_masuk)
    {
        $barang_masuk->delete();
        return redirect()->route('barang-masuk.index')->with('success', 'Data barang masuk berhasil dihapus.');
    }
}
