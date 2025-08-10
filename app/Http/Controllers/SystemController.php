<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Village;
use App\Models\Transfer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class SystemController extends Controller
{
    /**
     * Display the system settings dashboard.
     */
    public function index()
    {
        // System Statistics
        $systemStats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'total_villages' => Village::count(),
            'total_transfers' => Transfer::count(),
            'database_size' => $this->getDatabaseSize(),
            'cache_size' => $this->getCacheSize(),
        ];

        // System Information
        $systemInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'database_connection' => config('database.default'),
            'timezone' => config('app.timezone'),
            'environment' => config('app.env'),
        ];

        // Recent Activity
        $recentActivity = [
            'latest_user' => User::latest()->first(),
            'latest_village' => Village::latest()->first(),
            'latest_transfer' => Transfer::with(['employee', 'fromVillage', 'toVillage'])->latest()->first(),
        ];

        return view('admin.system.index', compact('systemStats', 'systemInfo', 'recentActivity'));
    }

    /**
     * Display system maintenance page.
     */
    public function maintenance()
    {
        return view('admin.system.maintenance');
    }

    /**
     * Clear application cache.
     */
    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            return redirect()->back()->with('success', 'Cache berhasil dibersihkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membersihkan cache: ' . $e->getMessage());
        }
    }

    /**
     * Optimize application.
     */
    public function optimize()
    {
        try {
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');

            return redirect()->back()->with('success', 'Aplikasi berhasil dioptimalkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengoptimalkan aplikasi: ' . $e->getMessage());
        }
    }

    /**
     * Display backup management page.
     */
    public function backup()
    {
        // Get list of backup files (if backup package is installed)
        $backups = [];
        
        return view('admin.system.backup', compact('backups'));
    }

    /**
     * Display system logs.
     */
    public function logs()
    {
        $logFile = storage_path('logs/laravel.log');
        $logs = [];

        if (file_exists($logFile)) {
            $logContent = file_get_contents($logFile);
            $logLines = array_reverse(explode("\n", $logContent));
            
            // Get last 100 lines
            $logs = array_slice(array_filter($logLines), 0, 100);
        }

        return view('admin.system.logs', compact('logs'));
    }

    /**
     * Display database management page.
     */
    public function database()
    {
        // Get table information
        $tables = DB::select('SHOW TABLES');
        $tableInfo = [];

        foreach ($tables as $table) {
            $tableName = array_values((array) $table)[0];
            $rowCount = DB::table($tableName)->count();
            $tableInfo[] = [
                'name' => $tableName,
                'rows' => $rowCount
            ];
        }

        return view('admin.system.database', compact('tableInfo'));
    }

    /**
     * Run database migrations.
     */
    public function migrate()
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
            $output = Artisan::output();

            return redirect()->back()->with('success', 'Migrasi database berhasil dijalankan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menjalankan migrasi: ' . $e->getMessage());
        }
    }

    /**
     * Get database size.
     */
    private function getDatabaseSize()
    {
        try {
            $databaseName = config('database.connections.mysql.database');
            $result = DB::select("
                SELECT 
                    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS size_mb
                FROM information_schema.tables 
                WHERE table_schema = ?
            ", [$databaseName]);

            return $result[0]->size_mb ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get cache size (approximate).
     */
    private function getCacheSize()
    {
        try {
            $cacheDir = storage_path('framework/cache');
            if (!is_dir($cacheDir)) {
                return 0;
            }

            $size = 0;
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($cacheDir)
            );

            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    $size += $file->getSize();
                }
            }

            return round($size / 1024 / 1024, 2); // Convert to MB
        } catch (\Exception $e) {
            return 0;
        }
    }
}
