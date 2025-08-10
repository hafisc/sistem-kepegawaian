<?php

namespace App\Http\Controllers;

use App\Models\TransferType;
use Illuminate\Http\Request;
use App\Traits\NotifiesUsers;

class TransferTypeController extends Controller
{
    use NotifiesUsers;

    /**
     * Display a listing of transfer types.
     */
    public function index()
    {
        $transferTypes = TransferType::orderBy('name')->paginate(15);
        return view('admin.transfer-types.index', compact('transferTypes'));
    }

    /**
     * Show the form for creating a new transfer type.
     */
    public function create()
    {
        return view('admin.transfer-types.create');
    }

    /**
     * Store a newly created transfer type.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:transfer_types',
            'description' => 'nullable|string',
            'requires_approval' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $transferType = TransferType::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'requires_approval' => $request->boolean('requires_approval', true),
            'is_active' => $request->boolean('is_active', true)
        ]);

        $this->notifySuccess('created', $transferType, 'Jenis Mutasi');

        return redirect()->route('admin.transfer-types.index')->with('success', 'Jenis mutasi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing transfer type.
     */
    public function edit(TransferType $transferType)
    {
        return view('admin.transfer-types.edit', compact('transferType'));
    }

    /**
     * Update the specified transfer type.
     */
    public function update(Request $request, TransferType $transferType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:transfer_types,code,' . $transferType->id,
            'description' => 'nullable|string',
            'requires_approval' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $transferType->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'requires_approval' => $request->boolean('requires_approval', true),
            'is_active' => $request->boolean('is_active', true)
        ]);

        $this->notifySuccess('updated', $transferType, 'Jenis Mutasi');

        return redirect()->route('admin.transfer-types.index')->with('success', 'Jenis mutasi berhasil diperbarui.');
    }

    /**
     * Remove the specified transfer type.
     */
    public function destroy(TransferType $transferType)
    {
        // Check if transfer type is being used
        if ($transferType->transfers()->count() > 0) {
            return redirect()->route('admin.transfer-types.index')->with('error', 'Jenis mutasi tidak dapat dihapus karena masih digunakan.');
        }

        $transferType->delete();
        $this->notifySuccess('deleted', $transferType, 'Jenis Mutasi');

        return redirect()->route('admin.transfer-types.index')->with('success', 'Jenis mutasi berhasil dihapus.');
    }
}
