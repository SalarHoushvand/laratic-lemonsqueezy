<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AiUsageController as AdminAiUsageController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SubscriptionInvoiceController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubscriptionController;
use App\Livewire\Admin\FileUpload;
use App\Livewire\Admin\PlansProducts;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Subscription\Manage;
use Illuminate\Support\Facades\Route;

Route::view('/waitlist', 'pages.waitlist')->name('waitlist');

// Redirect all routes to the waitlist
// Route::any('{any}', function () {
//     return redirect()->route('waitlist');
// })->where('any', '.*');

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/request-demo', 'pages.request-demo')->name('request-demo');
Route::view('/careers', 'pages.careers')->name('careers');
Route::view('/about-us', 'pages.about-us')->name('about-us');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/terms', 'pages.terms')->name('terms');
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::get('/pricing', [PlanController::class, 'pricing'])->name('pricing');
Route::view('/icons-preview', 'pages.icons-preview')->name('icons-preview');
Route::view('/test-hero', 'pages.test-hero')->name('test-hero');

// Blog routes
Route::controller(PostController::class)->group(function () {
    Route::get('/blog', 'index')->name('blog');
    Route::get('/blog/{slug}', 'show')->name('posts.show');
});

// Documentation routes (supports nested topics like ai/simple)
Route::get('/docs/{topic}', [DocumentationController::class, 'show'])
    ->where('topic', '.*')
    ->name('docs.show');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'two-factor-auth'])
    ->name('dashboard');

Route::middleware(['auth', 'two-factor-auth'])->group(function () {
    // Route::redirect('settings', 'settings/profile');

    Route::view('settings', 'pages.settings')->name('settings');

    Route::livewire('settings/profile', Profile::class)->name('settings.profile');
    Route::livewire('settings/password', Password::class)->name('settings.password');
    Route::livewire('settings/appearance', Appearance::class)->name('settings.appearance');

    // Plans
    Route::controller(PlanController::class)->prefix('plans')->name('plans.')->group(function () {
        Route::get('/start', 'index')->name('start');
        Route::get('/{price_id}', 'show')->name('show');
    });

    // Check subscription status
    Route::get('/subscription/pending', [SubscriptionController::class, 'pending'])->name('subscription.pending');
    Route::get('/subscription/status', [SubscriptionController::class, 'status'])->name('subscription.status');

    // Subscription required
    Route::middleware('subscribed')->group(function () {
        Route::livewire('/subscription', Manage::class)->name('subscription.manage');
    });

    // Products
    Route::controller(ProductController::class)->prefix('products')->name('products.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{product}', 'show')->name('show');
    });

    // Order
    Route::controller(OrderController::class)->prefix('orders')->name('orders.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/status/{order_id}', 'status')->name('status');
        Route::get('/pending/{order_id}', 'pending')->name('pending');
    });

    // Subscription Invoices
    Route::controller(SubscriptionInvoiceController::class)->prefix('subscription-invoices')->name('subscription-invoices.')->group(function () {
        Route::get('/', 'index')->name('index');
    });

    // AI Chat routes
    Route::get('/ai-chat', [AiController::class, 'index'])->name('ai.chat');
    Route::get('/ai-simple', [AiController::class, 'simple'])->name('ai.simple');

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');
        Route::get('/admin/users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');
        Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
        Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::get('/admin/ai-usage', [AdminAiUsageController::class, 'index'])->name('admin.ai-usage');
        Route::livewire('/admin/files/upload', FileUpload::class)->name('admin.files.upload');
        Route::livewire('/admin/plans-products', PlansProducts::class)->name('admin.plans-products');

        // Admin blog posts
        Route::controller(AdminPostController::class)->prefix('admin/posts')->name('admin.posts.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/{post}', 'edit')->name('edit');
        });
    });
});

Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirectToGoogle'])
    ->name('auth.google.redirect');

Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])
    ->name('auth.google.callback');

Route::get('/auth/github/redirect', [SocialAuthController::class, 'redirectToGithub'])
    ->name('auth.github.redirect');

Route::get('/auth/github/callback', [SocialAuthController::class, 'handleGithubCallback'])
    ->name('auth.github.callback');

// Error page test routes (for development/testing)
Route::prefix('test/errors')->name('test.errors.')->group(function () {
    Route::get('/400', function () {
        abort(400);
    })->name('400');
    Route::get('/401', function () {
        abort(401);
    })->name('401');
    Route::get('/403', function () {
        abort(403);
    })->name('403');
    Route::get('/404', function () {
        abort(404);
    })->name('404');
    Route::get('/419', function () {
        abort(419);
    })->name('419');
    Route::get('/429', function () {
        abort(429);
    })->name('429');
    Route::get('/500', function () {
        abort(500);
    })->name('500');
    Route::get('/503', function () {
        abort(503);
    })->name('503');
});

Route::get('/test', function () {
    return view('dashboard-test');
});

require __DIR__.'/auth.php';
