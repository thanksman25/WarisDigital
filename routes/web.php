<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public Routes
Route::get('/', function () {
    return Inertia::render('Landing');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return Inertia::render('Auth/Login');
    })->name('login');
    
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
    
    Route::get('/register', function () {
        return Inertia::render('Auth/Register');
    })->name('register');
    
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
    
    Route::get('/forgot-password', function () {
        return Inertia::render('Auth/Login');
    })->name('password.request');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        $userId = auth()->id();
        
        // Count total documents
        $totalDocs = \App\Models\Document::where('user_id', $userId)->count();
        
        // Count and value of assets
        $totalAssets = \App\Models\Asset::where('user_id', $userId)->where('is_active', true)->count();
        $totalAssetsVal = \App\Models\Asset::where('user_id', $userId)->where('is_active', true)->sum('value');
        
        // Count unique family members with access permissions
        $heirsCount = \App\Models\AccessPermission::whereHas('document', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->distinct('user_id')->count('user_id');
        
        // Reminders count (expiring in 30 days)
        $dueCount = \App\Models\Reminder::where('user_id', $userId)
            ->where('is_sent', false)
            ->where('remind_at', '<=', now()->addDays(30))
            ->count();
            
        // Stats
        $stats = [
            'totalDokumen' => $totalDocs,
            'totalDokumenTrend' => 'Jumlah dokumen saat ini',
            'totalAset' => $totalAssets,
            'totalAsetNilai' => 'Rp ' . number_format($totalAssetsVal, 0, ',', '.') . ' total nilai',
            'ahliWaris' => $heirsCount,
            'ahliWarisTrend' => 'Penerima akses terdaftar',
            'jatuhTempo' => $dueCount,
        ];
        
        // Upcoming Documents based on active reminders
        $upcomingDocuments = \App\Models\Reminder::where('user_id', $userId)
            ->where('is_sent', false)
            ->where('remind_at', '>=', now())
            ->orderBy('remind_at', 'asc')
            ->take(3)
            ->get()
            ->map(function ($reminder) {
                $daysLeft = now()->diffInDays($reminder->remind_at);
                $urgency = 'success';
                if ($daysLeft <= 7) {
                    $urgency = 'danger';
                } elseif ($daysLeft <= 30) {
                    $urgency = 'warn';
                }
                return [
                    'name' => $reminder->title,
                    'expiry' => $reminder->remind_at->format('d M Y'),
                    'label' => $daysLeft . ' hari',
                    'urgency' => $urgency,
                ];
            })->toArray();
            
        // Recent Activities from uploads & asset creation
        $docsActivity = \App\Models\Document::where('user_id', $userId)->latest()->take(2)->get()->map(function ($doc) {
            return [
                'text' => 'Dokumen "' . $doc->title . '" berhasil diunggah',
                'time' => $doc->created_at->diffForHumans(),
                'color' => '#F0AD52',
                'timestamp' => $doc->created_at->timestamp,
            ];
        });
        
        $assetsActivity = \App\Models\Asset::where('user_id', $userId)->latest()->take(2)->get()->map(function ($asset) {
            return [
                'text' => 'Aset "' . $asset->name . '" telah terdaftar',
                'time' => $asset->created_at->diffForHumans(),
                'color' => '#A76430',
                'timestamp' => $asset->created_at->timestamp,
            ];
        });
        
        $activities = $docsActivity->concat($assetsActivity)->sortByDesc('timestamp')->values()->take(4)->toArray();
        
        // Document Completeness
        $categories = ['Identitas', 'Properti', 'Keuangan', 'Kendaraan'];
        $completeness = [];
        foreach ($categories as $cat) {
            $hasDoc = \App\Models\Document::where('user_id', $userId)
                ->where('file_type', $cat)
                ->exists();
            $completeness[] = [
                'label' => $cat === 'Identitas' ? 'Identitas & KTP' : $cat,
                'value' => $hasDoc ? 100 : 0,
                'color' => $hasDoc ? '#27ae60' : '#e67e22',
            ];
        }

        return Inertia::render('Dashboard/Index', [
            'user' => [
                'name' => auth()->user()->name,
                'initials' => collect(explode(' ', auth()->user()->name))->map(fn($w) => mb_substr($w, 0, 1))->take(2)->join(''),
                'role' => 'Kepala Keluarga',
            ],
            'stats' => $stats,
            'recentActivities' => $activities,
            'upcomingDocuments' => $upcomingDocuments,
            'documentCompleteness' => $completeness,
        ]);
    })->name('dashboard');

    // Vault/Documents
    Route::get('/documents', [\App\Http\Controllers\VaultController::class, 'index'])->name('documents.index');
    Route::get('/documents/create', fn () => Inertia::render('Documents/Create'))->name('documents.create');
    Route::post('/documents', [\App\Http\Controllers\VaultController::class, 'store'])->name('documents.store');
    Route::delete('/documents/{id}', [\App\Http\Controllers\VaultController::class, 'destroy'])->name('documents.destroy');
    Route::get('/documents/show', [\App\Http\Controllers\VaultController::class, 'show'])->name('documents.show');

    // Profile
    Route::get('/profile', function () {
        $user = auth()->user();
        return Inertia::render('Profile/Index', [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => '0812-9876-5432',
                'nik' => '3171020304050001',
                'role' => 'Kepala Keluarga',
                'joined' => $user->created_at ? $user->created_at->translatedFormat('F Y') : 'Januari 2024',
                'plan' => 'Premium',
            ]
        ]);
    })->name('profile');

    Route::put('/profile', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
        ]);

        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    })->name('profile.update');

    Route::put('/profile/password', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'current' => 'required|current_password',
            'new' => 'required|string|min:8',
        ]);

        auth()->user()->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->new),
        ]);

        return redirect()->route('profile')->with('success', 'Password berhasil diubah.');
    })->name('profile.password');

    // Assets
    Route::get('/assets', [\App\Http\Controllers\AssetController::class, 'index'])->name('assets.index');
    Route::get('/assets/create', fn () => Inertia::render('Assets/Create'))->name('assets.create');
    Route::post('/assets', [\App\Http\Controllers\AssetController::class, 'store'])->name('assets.store');

    // Access
    Route::get('/access', [\App\Http\Controllers\AccessPermissionController::class, 'index'])->name('access.index');
    Route::get('/access/create', [\App\Http\Controllers\AccessPermissionController::class, 'create'])->name('access.create');
    Route::post('/access', [\App\Http\Controllers\AccessPermissionController::class, 'store'])->name('access.store');
    Route::delete('/access/{id}', [\App\Http\Controllers\AccessPermissionController::class, 'destroy'])->name('access.destroy');

    // Reminders
    Route::get('/reminders', [\App\Http\Controllers\ReminderController::class, 'index'])->name('reminders.index');

    // Time Capsules
    Route::get('/time-capsule', [\App\Http\Controllers\TimeCapsuleController::class, 'index'])->name('time-capsule.index');
    Route::get('/time-capsule/create', function () {
        return Inertia::render('TimeCapsule/Create', [
            'documents' => \App\Models\Document::where('user_id', auth()->id())->get(),
        ]);
    })->name('time-capsule.create');
    Route::post('/time-capsule', [\App\Http\Controllers\TimeCapsuleController::class, 'store'])->name('time-capsule.store');
    Route::get('/time-capsule/{id}', [\App\Http\Controllers\TimeCapsuleController::class, 'show'])->name('time-capsule.show');

    // Inheritance
    Route::get('/inheritance', [\App\Http\Controllers\InheritanceController::class, 'index'])->name('inheritance.index');
    Route::post('/inheritance', [\App\Http\Controllers\InheritanceController::class, 'store'])->name('inheritance.store');
    Route::delete('/inheritance/{id}', [\App\Http\Controllers\InheritanceController::class, 'destroy'])->name('inheritance.destroy');

    // Notaries
    Route::get('/notary', [\App\Http\Controllers\NotaryController::class, 'index'])->name('notary.index');

    // Claim Guides
    Route::get('/claims', [\App\Http\Controllers\ClaimGuideController::class, 'index'])->name('claims.index');
});