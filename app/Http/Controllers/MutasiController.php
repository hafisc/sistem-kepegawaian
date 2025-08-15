<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transfer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MutasiController extends Controller
{
    /**
     * Display a listing of mutasi data
     */
    public function index(Request $request)
    {
        $query = Transfer::with('employee')
                        ->whereNotNull('sk_number')
                        ->orderBy('sk_date', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('sk_number', 'like', "%{$search}%")
                  ->orWhere('from_unit', 'like', "%{$search}%")
                  ->orWhere('to_unit', 'like', "%{$search}%")
                  ->orWhereHas('employee', function($eq) use ($search) {
                      $eq->where('name', 'like', "%{$search}%")
                         ->orWhere('username', 'like', "%{$search}%");
                  });
            });
        }

        $transfers = $query->paginate(10)->withQueryString();
        
        return view('admin.mutasi.index', compact('transfers'));
    }

    /**
     * Show the form for creating a new mutasi
     */
    public function create()
    {
        $employees = User::where('role', 'user')->get();
        return view('admin.mutasi.create', compact('employees'));
    }

    /**
     * Store a newly created mutasi in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'transfer_type' => 'required|in:Masuk,Keluar',
            'sk_number' => 'required|string|max:255',
            'sk_date' => 'required|date',
            'from_unit' => 'nullable|string|max:255',
            'to_unit' => 'required|string|max:255',
            'position_before' => 'nullable|string|max:255',
            'position_after' => 'nullable|string|max:255',
            'reason' => 'nullable|string',
            'sk_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'supporting_docs' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $transferData = [
            'employee_id' => $request->employee_id,
            'from_unit' => $request->from_unit,
            'to_unit' => $request->to_unit,
            'transfer_date' => $request->sk_date,
            'effective_date' => $request->sk_date,
            'sk_number' => $request->sk_number,
            'sk_date' => $request->sk_date,
            'position_before' => $request->position_before,
            'position_after' => $request->position_after,
            'reason' => $request->reason,
            'status' => 'completed',
            'transfer_type' => strtolower($request->transfer_type),
        ];

        $transfer = Transfer::create($transferData);

        // Handle file uploads
        if ($request->hasFile('sk_file')) {
            $skPath = $request->file('sk_file')->store('transfers/sk', 'public');
            $transfer->update(['sk_file' => $skPath]);
        }

        if ($request->hasFile('supporting_docs')) {
            $docsPath = $request->file('supporting_docs')->store('transfers/docs', 'public');
            $transfer->update(['supporting_docs' => $docsPath]);
        }

        return redirect()->route('admin.mutasi.index')
                        ->with('success', 'Data mutasi berhasil ditambahkan.');
    }
    /**
     * Show mutasi masuk form for a specific user
     */
    public function showMutasiMasuk(User $user)
    {
        return view('admin.mutasi.mutasi-masuk', compact('user'));
    }

    /**
     * Store mutasi masuk data
     */
    public function storeMutasiMasuk(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'from_unit' => 'required|string|max:255',
            'to_unit' => 'required|string|max:255',
            'transfer_date' => 'required|date',
            'effective_date' => 'required|date|after_or_equal:transfer_date',
            'sk_number' => 'required|string|max:255',
            'sk_date' => 'required|date',
            'position_before' => 'nullable|string|max:255',
            'position_after' => 'nullable|string|max:255',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
            'sk_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'supporting_docs' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $user = User::findOrFail($request->user_id);

        // Create transfer record
        $transferData = [
            'employee_id' => $user->id,
            'from_village_id' => null, // We'll use from_unit instead
            'to_village_id' => null,   // We'll use to_unit instead
            'from_unit' => $request->from_unit,
            'to_unit' => $request->to_unit,
            'transfer_date' => $request->transfer_date,
            'effective_date' => $request->effective_date,
            'sk_number' => $request->sk_number,
            'sk_date' => $request->sk_date,
            'position_before' => $request->position_before,
            'position_after' => $request->position_after,
            'reason' => $request->reason,
            'notes' => $request->notes,
            'status' => 'completed',
            'transfer_type' => 'masuk',
        ];

        $transfer = Transfer::create($transferData);

        // Handle file uploads
        if ($request->hasFile('sk_file')) {
            $skPath = $request->file('sk_file')->store('transfers/sk', 'public');
            $transfer->update(['sk_file' => $skPath]);
        }

        if ($request->hasFile('supporting_docs')) {
            $docsPath = $request->file('supporting_docs')->store('transfers/docs', 'public');
            $transfer->update(['supporting_docs' => $docsPath]);
        }

        // Update user's work unit if different
        if ($user->work_unit !== $request->to_unit) {
            $user->update(['work_unit' => $request->to_unit]);
        }

        // Check if mutation is within same district (keep status active)
        // For intra-district mutations, employee status remains active
        $fromDistrict = $this->extractDistrict($request->from_unit);
        $toDistrict = $this->extractDistrict($request->to_unit);
        
        if ($fromDistrict === $toDistrict) {
            // Intra-district mutation - keep employee active
            $user->update(['employment_status' => 'Aktif']);
        }

        return redirect()->route('admin.mutasi.riwayat', $user->id)
            ->with('success', 'Data mutasi masuk berhasil disimpan. Silakan lengkapi riwayat mutasi.');
    }

    /**
     * Show riwayat mutasi form for a specific user
     */
    public function showRiwayatMutasi(User $user)
    {
        return view('admin.mutasi.riwayat-mutasi', compact('user'));
    }

    /**
     * Store riwayat mutasi data
     */
    public function storeRiwayatMutasi(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'history' => 'required|array|min:1',
            'history.*.from_unit' => 'required|string|max:255',
            'history.*.to_unit' => 'required|string|max:255',
            'history.*.transfer_date' => 'required|date',
            'history.*.sk_number' => 'nullable|string|max:255',
            'history.*.position_before' => 'nullable|string|max:255',
            'history.*.position_after' => 'nullable|string|max:255',
            'history.*.reason' => 'nullable|string',
            'total_mutations' => 'required|integer|min:1',
            'last_mutation_date' => 'nullable|date',
            'general_notes' => 'nullable|string',
        ]);

        $user = User::findOrFail($request->user_id);

        DB::transaction(function () use ($request, $user) {
            // Store each history item as a transfer record
            foreach ($request->history as $index => $historyItem) {
                Transfer::create([
                    'employee_id' => $user->id,
                    'from_village_id' => null,
                    'to_village_id' => null,
                    'from_unit' => $historyItem['from_unit'],
                    'to_unit' => $historyItem['to_unit'],
                    'transfer_date' => $historyItem['transfer_date'],
                    'effective_date' => $historyItem['transfer_date'], // Same as transfer date for history
                    'sk_number' => $historyItem['sk_number'] ?? null,
                    'position_before' => $historyItem['position_before'] ?? null,
                    'position_after' => $historyItem['position_after'] ?? null,
                    'reason' => $historyItem['reason'] ?? 'Riwayat mutasi sebelumnya',
                    'notes' => $request->general_notes,
                    'status' => 'completed',
                    'transfer_type' => 'riwayat',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Update user's mutation summary
            $user->update([
                'total_mutations' => $request->total_mutations,
                'last_mutation_date' => $request->last_mutation_date,
                'mutation_notes' => $request->general_notes,
            ]);
        });

        return redirect()->route('admin.users')
            ->with('success', 'Data pegawai PNS berhasil ditambahkan lengkap dengan mutasi masuk dan riwayat mutasi.');
    }

    /**
     * Extract district from unit name for comparison
     * This is a simple implementation - can be enhanced based on naming conventions
     */
    private function extractDistrict($unitName)
    {
        // Simple logic to extract district/kecamatan from unit name
        // This can be enhanced based on your specific naming conventions
        
        // Common patterns: "Kecamatan X", "Desa Y Kecamatan X", etc.
        if (preg_match('/kecamatan\s+([^,\s]+)/i', $unitName, $matches)) {
            return strtolower(trim($matches[1]));
        }
        
        // If no kecamatan found, assume it's a village and extract potential district
        // You might want to have a mapping table for this in production
        $parts = explode(' ', strtolower($unitName));
        
        // Look for common district indicators
        foreach ($parts as $index => $part) {
            if (in_array($part, ['kec', 'kecamatan']) && isset($parts[$index + 1])) {
                return $parts[$index + 1];
            }
        }
        
        // Default: return the unit name itself for exact matching
        return strtolower(trim($unitName));
    }
}
