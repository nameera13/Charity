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
use App\Http\Controllers\Front\CausesController;
use App\Http\Controllers\Front\ContactUsController;
use App\Http\Controllers\Front\SubscriberController;



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
use App\Http\Controllers\Admin\EventTicketController;
use App\Http\Controllers\Admin\CauseController;
use App\Http\Controllers\Admin\CausePhotoController;
use App\Http\Controllers\Admin\CauseVideoController;
use App\Http\Controllers\Admin\CauseFaqController;
use App\Http\Controllers\Admin\CauseDonationController;
use App\Http\Controllers\Admin\HomePageItemController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PagePolicyController;
use App\Http\Controllers\Admin\SubscribersController;



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


/*----------------Front Routes----------------*/

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

Route::post('events/ticket/payment', [EventsController::class, 'payment']);
Route::get('events/ticket/payment-success', [EventsController::class, 'payment_success'])->name('event_ticket_razorpay_success');
Route::get('events/ticket/payment-cancel', [EventsController::class, 'payment_cancel'])->name('event_ticket_cancel');
Route::post('events/ticket/free-booking', [EventsController::class, 'free_booking']);

Route::get('causes', [CausesController::class, 'index']);
Route::get('causes/{slug}', [CausesController::class, 'details']);
Route::post('causes/send-message', [CausesController::class, 'send_message']);

Route::post('donation/payment', [CausesController::class, 'payment']);
Route::get('donation/payment-success', [CausesController::class, 'payment_success'])->name('donation_payment_success');
Route::get('donation/payment-cancel', [CausesController::class, 'payment_cancel'])->name('donation_payment_cancel');

Route::get('contact-us', [ContactUsController::class, 'index']);
Route::post('contact-us', [ContactUsController::class, 'contact_us']);

Route::get('/terms-and-conditions', [HomeController::class, 'terms_conditions']);
Route::get('/privacy-policy', [HomeController::class, 'privacy_policy']);

Route::post('subscriber', [SubscriberController::class, 'subscriber']);
Route::get('subscriber-verify/{email}/{token}', [SubscriberController::class, 'subscriber_verify']);


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth','verified')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::put('/profile', [ProfileController::class, 'profile'])->name('profile.update');
    Route::put('/change-password', [ProfileController::class, 'changePassword']);
    Route::get('event-tickets-datatable', [ProfileController::class, 'ticketDataTable']);
    Route::get('event-tickets/invoice/{id}', [ProfileController::class, 'ticketInvoice']);
    Route::get('cause-donations-datatable', [ProfileController::class, 'donationDataTable']);
    Route::get('cause-donations/invoice/{id}', [ProfileController::class, 'donationInvoice']);

});


/*----------------End Front Routes ----------------*/


require __DIR__.'/auth.php';






/*----------------Admin Routes----------------*/

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

    /*-- Event Ticket --*/
    Route::get('event/tickets/{id}', [EventTicketController::class, 'tickets']);
    Route::get('event-ticket-datatable', [EventTicketController::class, 'getDataTable']);
    Route::get('event-ticket/invoice/{id}', [EventTicketController::class, 'ticketInvoice']);

    /*-- Cause --*/
    Route::resource('cause',CauseController::class);
    Route::get('cause-datatable', [CauseController::class, 'getDataTable']);
    Route::post('cause/check-name-unique', [EventController::class, 'checkIsCauseNameUnique']);
 
    /*-- Cause Photo --*/
    Route::get('cause/photo/{id}', [CausePhotoController::class, 'photo']);
    Route::get('cause-photo-datatable', [CausePhotoController::class, 'getDataTable']);
    Route::post('cause-photo', [CausePhotoController::class, 'store']);
    Route::delete('cause-photo/{id}', [CausePhotoController::class, 'destroy']);

    /*-- Cause Video --*/
    Route::get('cause/video/{id}', [CauseVideoController::class, 'video']);
    Route::get('cause-video-datatable', [CauseVideoController::class, 'getDataTable']);
    Route::post('cause-video', [CauseVideoController::class, 'store']);
    Route::delete('cause-video/{id}', [CauseVideoController::class, 'destroy']);

    /*-- Cause Faqs --*/
    Route::get('cause/faq/{id}', [CauseFaqController::class, 'faq']);
    Route::get('cause-faq-datatable', [CauseFaqController::class, 'getDataTable']);
    Route::post('cause-faq', [CauseFaqController::class, 'store']);
    Route::get('cause-faq/{id}/edit', [CauseFaqController::class, 'edit']);
    Route::put('cause-faq/{id}', [CauseFaqController::class, 'update']);
    Route::delete('cause-faq/{id}', [CauseFaqController::class, 'destroy']);

    /*-- Cause Donations --*/
    Route::get('cause/donations/{id}', [CauseDonationController::class, 'donations']);
    Route::get('cause-donation-datatable', [CauseDonationController::class, 'getDataTable']);
    Route::get('cause-donation/invoice/{id}', [CauseDonationController::class, 'donationInvoice']);
 
    /*-- Home Page Items --*/
    Route::get('home-page-item', [HomePageItemController::class, 'index']);
    Route::post('home-page-item', [HomePageItemController::class, 'update']);

    /*-- Setting --*/
    Route::get('setting', [SettingController::class, 'index']);
    Route::post('setting', [SettingController::class, 'update']);

    /*-- Terms --*/
    Route::get('terms', [PagePolicyController::class, 'terms']);
    Route::post('terms', [PagePolicyController::class, 'terms_update']);

    /*-- Privacy --*/
    Route::get('privacy', [PagePolicyController::class, 'privacy']);
    Route::post('privacy', [PagePolicyController::class, 'privacy_update']);

    
    /*-- Subscribers --*/
    Route::get('subscribers', [SubscribersController::class, 'index']);
    Route::get('subscribers-datatable', [SubscribersController::class, 'getDataTable']);
    Route::get('subscribers/send-message', [SubscribersController::class, 'send_message']);
    Route::post('subscribers/send-message', [SubscribersController::class, 'send_message_submit']);
    Route::get('subscribers/delete/{id}', [SubscribersController::class, 'destroy']);


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

/*----------------End Admin Routes----------------*/


