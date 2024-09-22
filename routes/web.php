<?php

use Illuminate\Support\Facades\Route;

// Front
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProfileController;
use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\FAQController;
use App\Http\Controllers\Front\VolunteerController;
use App\Http\Controllers\Front\PhotoGalleryController;
use App\Http\Controllers\Front\VideoGalleryController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\EventsController;


// Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SpecialController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\CounterController;
use App\Http\Controllers\Admin\FAQsController;
use App\Http\Controllers\Admin\AdminVolunteerController;
use App\Http\Controllers\Admin\PhotoCategoryController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Admin\VideoCategoryController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ReplyController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\EventPhotoController;
use App\Http\Controllers\Admin\EventVideoController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('front.home');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index']);
Route::get('/faqs', [FAQController::class, 'index']);
Route::get('/volunteers', [VolunteerController::class, 'index']);
Route::get('/volunteers/{id}', [VolunteerController::class, 'details']);
Route::get('/photo-gallery', [PhotoGalleryController::class, 'index']);
Route::get('/video-gallery', [VideoGalleryController::class, 'index']);
Route::get('/blog', [BlogController::class, 'index']);
Route::get('blog/{slug}', [BlogController::class, 'detail']);
Route::get('category/{slug}', [BlogController::class, 'category']);
Route::get('tag/{name}', [BlogController::class, 'tag']);
Route::post('comment', [BlogController::class, 'comment']);
Route::post('reply', [BlogController::class, 'reply']);
Route::get('events', [EventsController::class, 'index']);
Route::get('events/{slug}', [EventsController::class, 'details']);
Route::post('events/enquery', [EventsController::class, 'enquery']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth','verified')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::put('/profile', [ProfileController::class, 'profile'])->name('profile.update');
    Route::put('/change-password', [ProfileController::class, 'changePassword']);
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';






/*----- Admin -----*/

Route::middleware('admin')->prefix('admin')->group(function(){
    Route::get('/dashboard',[AdminController::class,'dashboard']);
    Route::get('/profile',[AdminController::class,'profile']);
    Route::post('/update-profile',[AdminController::class,'update_profile']);

    /*-- Slider --*/
    Route::resource('slider',SliderController::class);
    Route::get('slider-datatable', [SliderController::class, 'getDataTable']);

    /*-- Special --*/
    Route::get('/special',[SpecialController::class,'edit']);
    Route::put('/special/{id}',[SpecialController::class,'update']);

    /*-- Feature --*/
    Route::resource('feature',FeatureController::class);
    Route::get('feature-datatable', [FeatureController::class, 'getDataTable']);
    Route::post('feature-section-item', [FeatureController::class, 'featureSectionItem']);

    /*-- Testimonials --*/
    Route::resource('testimonial',TestimonialController::class);
    Route::get('testimonial-datatable', [TestimonialController::class, 'getDataTable']);
    Route::post('testimonial-section-item', [TestimonialController::class, 'testimonialSectionItem']);

    /*-- Counter --*/
    Route::get('counter',[CounterController::class,'edit']);
    Route::put('counter/{id}',[CounterController::class,'update']);
    
    /*-- FAQ --*/
    Route::resource('faqs',FAQsController::class);
    Route::get('faqs-datatable', [FAQsController::class, 'getDataTable']);
    
    /*-- Volunteer --*/
    Route::resource('volunteer',AdminVolunteerController::class);
    Route::get('volunteer-datatable', [AdminVolunteerController::class, 'getDataTable']);

    /*-- Photo Category --*/
    Route::resource('photo-category',PhotoCategoryController::class);
    Route::get('photo-category-datatable', [PhotoCategoryController::class, 'getDataTable']);
    
    /*-- Photo --*/
    Route::resource('photo',PhotoController::class);
    Route::get('photo-datatable', [PhotoController::class, 'getDataTable']);

    /*-- Video Category --*/
    Route::resource('video-category',VideoCategoryController::class);
    Route::get('video-category-datatable', [VideoCategoryController::class, 'getDataTable']);
    
    /*-- Video --*/
    Route::resource('video',VideoController::class);
    Route::get('video-datatable', [VideoController::class, 'getDataTable']);
    
    /*-- Post Category --*/
    Route::resource('post-category',PostCategoryController::class);
    Route::get('post-category-datatable', [PostCategoryController::class, 'getDataTable']);

    /*-- Post --*/
    Route::resource('post',PostController::class);
    Route::get('post-datatable', [PostController::class, 'getDataTable']);
    Route::post('post/check-title-unique', [PostController::class, 'checkIsTitleUnique']);

    /*-- Comments --*/
    Route::resource('comments',CommentController::class);
    Route::get('comments-datatable', [CommentController::class, 'getDataTable']);
    Route::get('comments-change-status/{id}', [CommentController::class, 'changeStatus']);

    /*-- Replies --*/
    Route::resource('replies',ReplyController::class);
    Route::get('replies-datatable', [ReplyController::class, 'getDataTable']);
    Route::get('replies-change-status/{id}', [ReplyController::class, 'changeStatus']);

    /*-- Event --*/
    Route::resource('event',EventController::class);
    Route::get('event-datatable', [EventController::class, 'getDataTable']);
    Route::post('event/check-name-unique', [EventController::class, 'checkIsEventNameUnique']);

    /*-- Event Photo --*/
    Route::get('event/photo/{id}', [EventPhotoController::class, 'photo']);
    Route::get('event-photo-datatable', [EventPhotoController::class, 'getDataTable']);
    Route::post('event-photo', [EventPhotoController::class, 'store']);
    Route::delete('event-photo/{id}', [EventPhotoController::class, 'destroy']);

    /*-- Event Video --*/
    Route::get('event/video/{id}', [EventVideoController::class, 'video']);
    Route::get('event-video-datatable', [EventVideoController::class, 'getDataTable']);
    Route::post('event-video', [EventVideoController::class, 'store']);
    Route::delete('event-video/{id}', [EventVideoController::class, 'destroy']);


});

Route::prefix('admin')->group(function(){
    Route::get('/login',[AdminController::class,'login']);
    Route::post('/login-submit',[AdminController::class,'login_submit']);
    Route::get('/logout',[AdminController::class,'logout']);
    Route::get('/forget-password',[AdminController::class,'forget_password']);
    Route::post('/forget-password-submit',[AdminController::class,'forget_password_submit']);
    Route::get('/reset-password/{token}/{email}',[AdminController::class,'reset_password']);
    Route::post('/reset-password-submit',[AdminController::class,'reset_password_submit']);
});
