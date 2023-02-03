<?php
use App\Http\Controllers\welcomeController;
use App\Http\Controllers\blogController;
use App\Http\Controllers\contactController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//To welcpme page
Route::get('/', [welcomeController::class, 'index'])->name('welcome.index');

// To blog page
Route::get('/blog', [blogController::class, 'index'])->name('blog.index');

//To create blog post for admin
Route::get('/blog/create', [blogController::class, 'create'])->name('blog.create');

// To single blog post
Route::get('/blog/{post:slug}', [blogController::class, 'show'])->name('blog.show');

// To edit blog post
Route::get('/blog/{post}/edit', [blogController::class, 'edit'])->name('blog.edit');

// To update blog post
Route::put('/blog/{post}', [blogController::class, 'update'])->name('blog.update');

// To delete blog post
Route::delete('/blog/{post}', [blogController::class, 'destroy'])->name('blog.destroy');

//To save blog post to DB
Route::post('/blog', [blogController::class, 'store'])->name('blog.store');

// To about page
Route::get('/about-us', function(){
    return view('about');
})->name('about');

// To contact page
Route::get('/contact-us', [contactController::class, 'index'])->name('contact.index');

// To store contact
Route::post('/contact-us', [contactController::class, 'store'])->name('contact.store');

//category resuorce controller
Route::resource('/categories', CategoryController::class);

//To login/register page
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
