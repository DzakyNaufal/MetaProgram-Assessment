<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriMetaProgram;
use App\Models\MetaProgram;
use App\Models\SubMetaProgram;
use App\Models\PertanyaanMetaProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MetaProgramController extends Controller
{
    /**
     * Display a listing of all meta programs.
     */
    public function index()
    {
        $kategoriMetaPrograms = KategoriMetaProgram::with('metaPrograms.subMetaPrograms')
            ->orderBy('id')
            ->get();

        $metaPrograms = MetaProgram::with(['kategori', 'subMetaPrograms', 'pertanyaan'])
            ->orderBy('id')
            ->get();

        $stats = [
            'total_kategori' => KategoriMetaProgram::count(),
            'total_meta_programs' => MetaProgram::count(),
            'total_sub_meta_programs' => SubMetaProgram::count(),
            'total_pertanyaan' => PertanyaanMetaProgram::count(),
        ];

        return view('admin.meta-programs.index', compact('kategoriMetaPrograms', 'metaPrograms', 'stats'));
    }

    /**
     * Display all kategori meta programs.
     */
    public function kategoriIndex()
    {
        $kategoris = KategoriMetaProgram::with('metaPrograms')->orderBy('id')->get();
        return view('admin.meta-programs.kategori-index', compact('kategoris'));
    }

    /**
     * Display all meta programs.
     */
    public function metaIndex()
    {
        $metaPrograms = MetaProgram::with(['kategori', 'subMetaPrograms', 'pertanyaan'])->orderBy('id')->get();
        return view('admin.meta-programs.meta-index', compact('metaPrograms'));
    }

    /**
     * Display all sub meta programs.
     */
    public function subMetaIndex()
    {
        $subMetaPrograms = SubMetaProgram::with('metaProgram')->orderBy('id')->get();
        return view('admin.meta-programs.sub-index', compact('subMetaPrograms'));
    }

    /**
     * Show the form for creating a new kategori meta program.
     */
    public function createKategori()
    {
        return view('admin.meta-programs.create-kategori');
    }

    /**
     * Store a new kategori meta program.
     */
    public function storeKategori(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'timer_duration' => 'nullable|integer|min:1|max:10800', // max 180 minutes = 10800 seconds
        ]);

        // Convert minutes to seconds
        $timerDuration = $request->filled('timer_duration') ? $request->timer_duration * 60 : 1800;

        KategoriMetaProgram::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
            'timer_duration' => $timerDuration,
        ]);

        return redirect()->route('admin.meta-programs.kategori.index')
            ->with('success', 'Kategori Meta Program berhasil ditambahkan.');
    }

    /**
     * Show the form for editing a kategori.
     */
    public function editKategori(KategoriMetaProgram $kategori)
    {
        return view('admin.meta-programs.edit-kategori', compact('kategori'));
    }

    /**
     * Update the kategori.
     */
    public function updateKategori(Request $request, KategoriMetaProgram $kategori)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'timer_duration' => 'nullable|integer|min:1|max:10800', // max 180 minutes = 10800 seconds
        ]);

        // Convert minutes to seconds
        $timerDuration = $request->filled('timer_duration') ? $request->timer_duration * 60 : 1800;

        $kategori->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
            'timer_duration' => $timerDuration,
        ]);

        return redirect()->route('admin.meta-programs.kategori.index')
            ->with('success', 'Kategori Meta Program berhasil diperbarui.');
    }

    /**
     * Delete the kategori.
     */
    public function destroyKategori(KategoriMetaProgram $kategori)
    {
        $kategori->delete();

        return redirect()->route('admin.meta-programs.kategori.index')
            ->with('success', 'Kategori Meta Program berhasil dihapus.');
    }

    /**
     * Show the form for creating a new meta program.
     */
    public function createMetaProgram()
    {
        $kategoriMetaPrograms = KategoriMetaProgram::orderBy('name')->pluck('name', 'id');
        return view('admin.meta-programs.create-meta', compact('kategoriMetaPrograms'));
    }

    /**
     * Store a new meta program.
     */
    public function storeMetaProgram(Request $request)
    {
        $request->validate([
            'kategori_meta_program_id' => 'nullable|exists:kategori_meta_programs,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scoring_type' => 'required|in:inverse,multi',
        ]);

        MetaProgram::create([
            'kategori_meta_program_id' => $request->kategori_meta_program_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'scoring_type' => $request->scoring_type,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.meta-programs.meta.index')
            ->with('success', 'Meta Program berhasil ditambahkan.');
    }

    /**
     * Show the form for creating a new sub meta program.
     */
    public function createSubMetaProgram()
    {
        $metaPrograms = MetaProgram::orderBy('name')->pluck('name', 'id');
        return view('admin.meta-programs.create-sub', compact('metaPrograms'));
    }

    /**
     * Store a new sub meta program.
     */
    public function storeSubMetaProgram(Request $request)
    {
        $request->validate([
            'meta_program_id' => 'required|exists:meta_programs,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        SubMetaProgram::create([
            'meta_program_id' => $request->meta_program_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.meta-programs.sub.index')
            ->with('success', 'Sub Meta Program berhasil ditambahkan.');
    }

    /**
     * Show the form for editing a sub meta program.
     */
    public function editSubMetaProgram(SubMetaProgram $sub)
    {
        $metaPrograms = MetaProgram::orderBy('name')->pluck('name', 'id');
        return view('admin.meta-programs.edit-sub', compact('sub', 'metaPrograms'));
    }

    /**
     * Update the sub meta program.
     */
    public function updateSubMetaProgram(Request $request, SubMetaProgram $sub)
    {
        $request->validate([
            'meta_program_id' => 'required|exists:meta_programs,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $sub->update([
            'meta_program_id' => $request->meta_program_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.meta-programs.sub.index')
            ->with('success', 'Sub Meta Program berhasil diperbarui.');
    }

    /**
     * Delete the sub meta program.
     */
    public function destroySubMetaProgram(SubMetaProgram $sub)
    {
        $sub->delete();

        return redirect()->route('admin.meta-programs.sub.index')
            ->with('success', 'Sub Meta Program berhasil dihapus.');
    }

    /**
     * Show the form for editing a meta program.
     */
    public function edit(MetaProgram $metaProgram)
    {
        $kategoriMetaPrograms = KategoriMetaProgram::orderBy('name')->pluck('name', 'id');
        $metaProgram->load('subMetaPrograms', 'pertanyaan');
        return view('admin.meta-programs.edit', compact('metaProgram', 'kategoriMetaPrograms'));
    }

    /**
     * Update the meta program.
     */
    public function update(Request $request, MetaProgram $metaProgram)
    {
        $request->validate([
            'kategori_meta_program_id' => 'nullable|exists:kategori_meta_programs,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scoring_type' => 'required|in:inverse,multi',
        ]);

        $metaProgram->update([
            'kategori_meta_program_id' => $request->kategori_meta_program_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'scoring_type' => $request->scoring_type,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.meta-programs.meta.index')
            ->with('success', 'Meta Program berhasil diperbarui.');
    }

    /**
     * Delete the meta program.
     */
    public function destroy(MetaProgram $metaProgram)
    {
        $metaProgram->delete();

        return redirect()->route('admin.meta-programs.meta.index')
            ->with('success', 'Meta Program berhasil dihapus.');
    }

    /**
     * Display all pertanyaan from all meta programs.
     */
    public function pertanyaanIndex(Request $request)
    {
        $query = PertanyaanMetaProgram::with(['metaProgram.kategori', 'subMetaProgram']);

        // Filter by kategori if selected
        if ($request->has('kategori_id') && $request->kategori_id) {
            $query->whereHas('metaProgram', function($q) use ($request) {
                $q->where('kategori_meta_program_id', $request->kategori_id);
            });
        }

        // Filter by meta program if selected
        if ($request->has('meta_program_id') && $request->meta_program_id) {
            $query->where('meta_program_id', $request->meta_program_id);
        }

        $pertanyaan = $query->orderBy('meta_program_id')->orderBy('id')->get();
        $kategoriMetaPrograms = KategoriMetaProgram::orderBy('order')->get();
        $metaPrograms = MetaProgram::orderBy('name')->get();

        // Group by kategori for display
        $groupedPertanyaan = $pertanyaan->groupBy(function($item) {
            return $item->metaProgram->kategori->name ?? 'Uncategorized';
        });

        return view('admin.meta-programs.pertanyaan-index', compact(
            'groupedPertanyaan',
            'kategoriMetaPrograms',
            'metaPrograms',
            'pertanyaan'
        ));
    }

    /**
     * Display pertanyaan for a specific meta program.
     */
    public function pertanyaan(MetaProgram $metaProgram)
    {
        $metaProgram->load(['subMetaPrograms', 'pertanyaan' => function($query) {
            $query->orderBy('id');
        }]);
        return view('admin.meta-programs.pertanyaan', compact('metaProgram'));
    }

    /**
     * Show the form for creating a new pertanyaan.
     */
    public function createPertanyaan(Request $request)
    {
        $metaPrograms = MetaProgram::with('subMetaPrograms')->orderBy('name')->get();
        $selectedMetaProgramId = $request->query('meta_program');
        return view('admin.meta-programs.create-pertanyaan', compact('metaPrograms', 'selectedMetaProgramId'));
    }

    /**
     * Store a new pertanyaan.
     */
    public function storePertanyaan(Request $request)
    {
        $request->validate([
            'meta_program_id' => 'required|exists:meta_programs,id',
            'sub_meta_program_id' => 'nullable|exists:sub_meta_programs,id',
            'pertanyaan' => 'required|string',
            'skala_sangat_setuju' => 'required|integer|min:1|max:6',
            'skala_setuju' => 'required|integer|min:1|max:6',
            'skala_agak_setuju' => 'required|integer|min:1|max:6',
            'skala_agak_tidak_setuju' => 'required|integer|min:1|max:6',
            'skala_tidak_setuju' => 'required|integer|min:1|max:6',
            'skala_sangat_tidak_setuju' => 'required|integer|min:1|max:6',
            'keterangan' => 'nullable|string',
        ]);

        PertanyaanMetaProgram::create([
            'meta_program_id' => $request->meta_program_id,
            'sub_meta_program_id' => $request->sub_meta_program_id,
            'pertanyaan' => $request->pertanyaan,
            'skala_sangat_setuju' => $request->skala_sangat_setuju,
            'skala_setuju' => $request->skala_setuju,
            'skala_agak_setuju' => $request->skala_agak_setuju,
            'skala_agak_tidak_setuju' => $request->skala_agak_tidak_setuju,
            'skala_tidak_setuju' => $request->skala_tidak_setuju,
            'skala_sangat_tidak_setuju' => $request->skala_sangat_tidak_setuju,
            'keterangan' => $request->keterangan,
            'is_negatif' => $request->has('is_negatif'),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.meta-programs.pertanyaan', $request->meta_program_id)
            ->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing a pertanyaan.
     */
    public function editPertanyaan(PertanyaanMetaProgram $pertanyaan)
    {
        $metaPrograms = MetaProgram::with('subMetaPrograms')->orderBy('name')->get();
        return view('admin.meta-programs.edit-pertanyaan', compact('pertanyaan', 'metaPrograms'));
    }

    /**
     * Update the pertanyaan.
     */
    public function updatePertanyaan(Request $request, PertanyaanMetaProgram $pertanyaan)
    {
        $request->validate([
            'meta_program_id' => 'required|exists:meta_programs,id',
            'sub_meta_program_id' => 'nullable|exists:sub_meta_programs,id',
            'pertanyaan' => 'required|string',
            'skala_sangat_setuju' => 'required|integer|min:1|max:6',
            'skala_setuju' => 'required|integer|min:1|max:6',
            'skala_agak_setuju' => 'required|integer|min:1|max:6',
            'skala_agak_tidak_setuju' => 'required|integer|min:1|max:6',
            'skala_tidak_setuju' => 'required|integer|min:1|max:6',
            'skala_sangat_tidak_setuju' => 'required|integer|min:1|max:6',
            'keterangan' => 'nullable|string',
        ]);

        $pertanyaan->update([
            'meta_program_id' => $request->meta_program_id,
            'sub_meta_program_id' => $request->sub_meta_program_id,
            'pertanyaan' => $request->pertanyaan,
            'skala_sangat_setuju' => $request->skala_sangat_setuju,
            'skala_setuju' => $request->skala_setuju,
            'skala_agak_setuju' => $request->skala_agak_setuju,
            'skala_agak_tidak_setuju' => $request->skala_agak_tidak_setuju,
            'skala_tidak_setuju' => $request->skala_tidak_setuju,
            'skala_sangat_tidak_setuju' => $request->skala_sangat_tidak_setuju,
            'keterangan' => $request->keterangan,
            'is_negatif' => $request->has('is_negatif'),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.meta-programs.pertanyaan', $request->meta_program_id)
            ->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    /**
     * Delete the pertanyaan.
     */
    public function destroyPertanyaan(PertanyaanMetaProgram $pertanyaan)
    {
        $metaProgramId = $pertanyaan->meta_program_id;
        $pertanyaan->delete();

        return redirect()->route('admin.meta-programs.pertanyaan', $metaProgramId)
            ->with('success', 'Pertanyaan berhasil dihapus.');
    }

    /**
     * Get sub meta programs by meta program (API for AJAX).
     */
    public function getSubMetaPrograms(MetaProgram $metaProgram)
    {
        return response()->json($metaProgram->subMetaPrograms);
    }
}
