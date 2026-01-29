<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        return view('kriteria.index', compact('kriteria'));
    }

    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_kriteria' => 'required|string|max:10|unique:kriteria,kode_kriteria',
            'nama_kriteria' => 'required|string|max:100',
            'jenis' => 'required|in:benefit,cost',
            'keterangan' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Kriteria::create($validated);

        return redirect()->route('kriteria.index')
            ->with('success', 'Data kriteria berhasil ditambahkan!');
    }

    public function show(Kriteria $kriterium)
    {
        return view('kriteria.show', compact('kriterium'));
    }

    public function edit(Kriteria $kriterium)
    {
        return view('kriteria.edit', compact('kriterium'));
    }

    public function update(Request $request, Kriteria $kriterium)
    {
        $validated = $request->validate([
            'kode_kriteria' => 'required|string|max:10|unique:kriteria,kode_kriteria,' . $kriterium->id,
            'nama_kriteria' => 'required|string|max:100',
            'jenis' => 'required|in:benefit,cost',
            'keterangan' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $kriterium->update($validated);

        return redirect()->route('kriteria.index')
            ->with('success', 'Data kriteria berhasil diupdate!');
    }

    public function destroy(Kriteria $kriterium)
    {
        try {
            $kriterium->delete();
            return redirect()->route('kriteria.index')
                ->with('success', 'Data kriteria berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('kriteria.index')
                ->with('error', 'Data kriteria tidak dapat dihapus karena masih digunakan!');
        }
    }
}