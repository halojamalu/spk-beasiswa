<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $siswa = Siswa::orderBy('nis')->get();
        return view('siswa.index', compact('siswa'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:siswa,nis',
            'nama_lengkap' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas' => 'required|string|max:10',
            'alamat' => 'nullable|string',
            'nama_ortu' => 'nullable|string|max:100',
            'pekerjaan_ortu' => 'nullable|string|max:100',
            'penghasilan_ortu' => 'nullable|numeric|min:0',
            'jumlah_tanggungan' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Siswa::create($validated);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function show(Siswa $siswa)
    {
        return view('siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:siswa,nis,' . $siswa->id,
            'nama_lengkap' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas' => 'required|string|max:10',
            'alamat' => 'nullable|string',
            'nama_ortu' => 'nullable|string|max:100',
            'pekerjaan_ortu' => 'nullable|string|max:100',
            'penghasilan_ortu' => 'nullable|numeric|min:0',
            'jumlah_tanggungan' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $siswa->update($validated);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil diupdate!');
    }

    public function destroy(Siswa $siswa)
    {
        try {
            $siswa->delete();
            return redirect()->route('siswa.index')
                ->with('success', 'Data siswa berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('siswa.index')
                ->with('error', 'Data siswa tidak dapat dihapus karena masih digunakan!');
        }
    }
}