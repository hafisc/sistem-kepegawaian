<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;
use App\Traits\NotifiesUsers;

class EducationController extends Controller
{
    use NotifiesUsers;

    /**
     * Display a listing of educations.
     */
    public function index()
    {
        $educations = Education::orderBy('level')->orderBy('name')->paginate(15);
        return view('admin.education.index', compact('educations'));
    }

    /**
     * Show the form for creating a new education.
     */
    public function create()
    {
        return view('admin.education.create');
    }

    /**
     * Store a newly created education.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|in:' . implode(',', array_keys(Education::LEVELS)),
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $education = Education::create([
            'name' => $request->name,
            'level' => $request->level,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true)
        ]);

        $this->notifySuccess('created', $education, 'Pendidikan');

        return redirect()->route('admin.education.index')->with('success', 'Data pendidikan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing education.
     */
    public function edit(Education $education)
    {
        return view('admin.education.edit', compact('education'));
    }

    /**
     * Update the specified education.
     */
    public function update(Request $request, Education $education)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|in:' . implode(',', array_keys(Education::LEVELS)),
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $education->update([
            'name' => $request->name,
            'level' => $request->level,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true)
        ]);

        $this->notifySuccess('updated', $education, 'Pendidikan');

        return redirect()->route('admin.education.index')->with('success', 'Data pendidikan berhasil diperbarui.');
    }

    /**
     * Remove the specified education.
     */
    public function destroy(Education $education)
    {
        // Check if education is being used
        if ($education->users()->count() > 0) {
            return redirect()->route('admin.education.index')->with('error', 'Pendidikan tidak dapat dihapus karena masih digunakan oleh pegawai.');
        }

        $education->delete();
        $this->notifySuccess('deleted', $education, 'Pendidikan');

        return redirect()->route('admin.education.index')->with('success', 'Data pendidikan berhasil dihapus.');
    }
}
