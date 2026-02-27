<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MetaProgramController;
use App\Http\Controllers\Admin\BankAccountController;
use App\Http\Controllers\Admin\PurchaseController as AdminPurchaseController;
use Illuminate\Support\Facades\Route;

// Route GET '/' ke HomeController@index (nama: home) – Tidak proteksi, akses bebas.
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route GET '/pricing' untuk halaman pricing (nama: pricing) – Tidak proteksi, akses bebas.
Route::get('/pricing', [App\Http\Controllers\ProductsController::class, 'index'])->name('pricing');

// Route GET '/products' ke ProductsController@index (nama: products) – Tidak proteksi, akses bebas.
Route::get('/products', [App\Http\Controllers\ProductsController::class, 'index'])->name('products');
// Note: The POST /products/buy route was removed to use /pricing/buy instead

// Route POST '/pricing/buy' ke PurchaseController@store (proteksi auth: middleware('auth'))
Route::post('/pricing/buy', [App\Http\Controllers\PurchaseController::class, 'store'])->middleware('auth')->name('pricing.buy');

// Route GET '/contact' ke ContactController@index (nama: contact) – Tidak proteksi, akses bebas.
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');

// Route POST '/contact' ke ContactController@store (simpan pesan)
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// Route untuk auth Breeze: require __DIR__.'/auth.php'; (login/register)
require __DIR__ . '/auth.php';

// User Area Routes (Proteksi: middleware('auth'))
Route::middleware('auth')->group(function () {
    // Courses - Order matters: more specific routes must come first
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/result/{quizAttemptId}', [CourseController::class, 'showResult'])->name('courses.result');
    Route::get('/courses/{courseSlug}/purchase', [CourseController::class, 'purchase'])->name('courses.purchase');
    Route::get('/courses/{courseSlug}/category/{categorySlug}/purchase', [CourseController::class, 'categoryPurchase'])->name('courses.category-purchase');
    Route::get('/courses/{courseSlug}/category/{categorySlug}/start', [CourseController::class, 'categoryStart'])->name('courses.category-start');
    Route::post('/courses/{courseSlug}/category/{categorySlug}/submit', [CourseController::class, 'submitCategoryQuiz'])->name('courses.submit-category-quiz');
    Route::post('/courses/{courseSlug}/submit', [CourseController::class, 'submitQuiz'])->name('courses.submit');

    // Single-kategori routes MUST come BEFORE {kategoriSlug} routes to avoid conflicts
    Route::post('/courses/{courseSlug}/single-kategori/submit', [CourseController::class, 'submitSingleKategoriQuiz'])->name('courses.single-kategori.submit');
    Route::post('/courses/{courseSlug}/single-kategori/save-progress', [CourseController::class, 'saveProgressSingleKategori'])->name('courses.single-kategori.save-progress');

    Route::post('/courses/{courseSlug}/reset-progress', [CourseController::class, 'resetCourseProgress'])->name('courses.reset-progress');
    Route::get('/courses/{courseSlug}/{kategoriSlug}', [CourseController::class, 'show'])->name('courses.kategori');
    Route::post('/courses/{courseSlug}/{kategoriSlug}/save-progress', [CourseController::class, 'saveProgress'])->name('courses.save-progress');
    Route::post('/courses/{courseSlug}/{kategoriSlug}/clear-progress', [CourseController::class, 'clearProgress'])->name('courses.clear-progress');
    Route::post('/courses/{courseSlug}/{kategoriSlug}/submit', [CourseController::class, 'submitKategoriQuiz'])->name('courses.submit-kategori');

    Route::get('/courses/{courseSlug}', [CourseController::class, 'show'])->name('courses.show');

    // History
    Route::get('/history', [CourseController::class, 'userHistory'])->name('user.history');
    Route::get('/dashboard', [CourseController::class, 'dashboard'])->name('dashboard');

    // Purchases
    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
    Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/purchases/{id}/payment', [PurchaseController::class, 'showPayment'])->name('purchases.payment');
    Route::post('/purchases/{id}/upload-proof', [PurchaseController::class, 'uploadProof'])->name('purchases.upload-proof');

    // Coupon validation
    Route::post('/api/coupons/validate/{code}', [PurchaseController::class, 'validateCoupon'])->name('coupons.validate');

    // Results
    Route::get('/results', [ResultController::class, 'index'])->name('results.index');
    Route::get('/results/{id}', [ResultController::class, 'show'])->name('results.show');
    Route::get('/results/{id}/whatsapp', [ResultController::class, 'redirectToWhatsApp'])->name('results.whatsapp');
    Route::get('/results/{id}/download', [ResultController::class, 'downloadPdf'])->name('results.download');
    Route::get('/results/{id}/personal-report', [ResultController::class, 'generatePersonalReport'])->name('results.personal-report');

    // Generate Dummy Assessment Data (for testing)
    Route::get('/generate-dummy-assessment', [ResultController::class, 'generateDummyData'])->name('results.generate-dummy');
});

// Admin Routes (Proteksi: middleware(['auth', 'admin']))
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Admin Profile
    Route::get('/profile', [App\Http\Controllers\AdminController::class, 'profile'])->name('profile');
    Route::patch('/profile', [App\Http\Controllers\AdminController::class, 'profileUpdate'])->name('profile.update');

    // Users
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    // Courses
    Route::resource('courses', AdminCourseController::class);

    // Bank Accounts
    Route::resource('bank-accounts', BankAccountController::class);

    // Purchases
    Route::get('/purchases', [AdminPurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/purchases/{purchase}', [AdminPurchaseController::class, 'show'])->name('purchases.show');
    Route::put('/purchases/{purchase}/confirm', [AdminPurchaseController::class, 'confirm'])->name('purchases.confirm');
    Route::put('/purchases/{purchase}/reject', [AdminPurchaseController::class, 'reject'])->name('purchases.reject');
    Route::delete('/purchases/{purchase}', [AdminPurchaseController::class, 'destroy'])->name('purchases.destroy');

    // Coupons
    Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);

    // Contacts routes
    Route::get('/contacts', [App\Http\Controllers\AdminController::class, 'contactsIndex'])->name('contacts.index');
    Route::post('/contacts', [App\Http\Controllers\AdminController::class, 'contactsStore'])->name('contacts.store');
    Route::get('/contacts/{contactMessage}', [App\Http\Controllers\AdminController::class, 'contactsShow'])->name('contacts.show');
    Route::delete('/contacts/{contactMessage}', [App\Http\Controllers\AdminController::class, 'contactsDestroy'])->name('contacts.destroy');

    // Meta Programs routes
    Route::prefix('meta-programs')->name('meta-programs.')->group(function () {
        Route::get('/', [MetaProgramController::class, 'index'])->name('index');

        // Kategori Meta Program
        Route::get('/kategori', [MetaProgramController::class, 'kategoriIndex'])->name('kategori.index');
        Route::get('/kategori/create', [MetaProgramController::class, 'createKategori'])->name('create-kategori');
        Route::post('/kategori', [MetaProgramController::class, 'storeKategori'])->name('store-kategori');
        Route::get('/kategori/{kategori}/edit', [MetaProgramController::class, 'editKategori'])->name('edit-kategori');
        Route::put('/kategori/{kategori}', [MetaProgramController::class, 'updateKategori'])->name('update-kategori');
        Route::delete('/kategori/{kategori}', [MetaProgramController::class, 'destroyKategori'])->name('destroy-kategori');

        // Meta Program
        Route::get('/meta', [MetaProgramController::class, 'metaIndex'])->name('meta.index');
        Route::get('/meta/create', [MetaProgramController::class, 'createMetaProgram'])->name('create-meta');
        Route::post('/meta', [MetaProgramController::class, 'storeMetaProgram'])->name('store-meta');
        Route::get('/meta/{metaProgram}/edit', [MetaProgramController::class, 'edit'])->name('edit');
        Route::put('/meta/{metaProgram}', [MetaProgramController::class, 'update'])->name('update');
        Route::delete('/meta/{metaProgram}', [MetaProgramController::class, 'destroy'])->name('destroy');

        // Sub Meta Program
        Route::get('/sub', [MetaProgramController::class, 'subMetaIndex'])->name('sub.index');
        Route::get('/sub/create', [MetaProgramController::class, 'createSubMetaProgram'])->name('create-sub');
        Route::post('/sub', [MetaProgramController::class, 'storeSubMetaProgram'])->name('store-sub');
        Route::get('/sub/{sub}/edit', [MetaProgramController::class, 'editSubMetaProgram'])->name('edit-sub');
        Route::put('/sub/{sub}', [MetaProgramController::class, 'updateSubMetaProgram'])->name('update-sub');
        Route::delete('/sub/{sub}', [MetaProgramController::class, 'destroySubMetaProgram'])->name('destroy-sub');

        // Pertanyaan
        Route::get('/pertanyaan', [MetaProgramController::class, 'pertanyaanIndex'])->name('pertanyaan.index');
        Route::get('/meta/{metaProgram}/pertanyaan', [MetaProgramController::class, 'pertanyaan'])->name('pertanyaan');
        Route::get('/pertanyaan/create', [MetaProgramController::class, 'createPertanyaan'])->name('create-pertanyaan');
        Route::post('/pertanyaan', [MetaProgramController::class, 'storePertanyaan'])->name('store-pertanyaan');
        Route::get('/pertanyaan/{pertanyaan}/edit', [MetaProgramController::class, 'editPertanyaan'])->name('edit-pertanyaan');
        Route::put('/pertanyaan/{pertanyaan}', [MetaProgramController::class, 'updatePertanyaan'])->name('update-pertanyaan');
        Route::delete('/pertanyaan/{pertanyaan}', [MetaProgramController::class, 'destroyPertanyaan'])->name('destroy-pertanyaan');

        // API for getting sub meta programs by meta program
        Route::get('/sub-meta-programs/{metaProgram}', [MetaProgramController::class, 'getSubMetaPrograms'])->name('get-sub-meta-programs');
    });
});

// Update profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
