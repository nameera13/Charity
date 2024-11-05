<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Slider;
use App\Models\Special;
use App\Models\Feature;
use App\Models\Testimonial;
use App\Models\EventTicket;
use App\Models\CauseDonation;
use App\Models\HomePageItem;
use App\Models\Cause;
use App\Models\Event;
use App\Models\Post;
use App\Models\PagePolicy;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::get();
        $special = Special::where('id', 1)->first();
        $features = Feature::get();
        $testimonials = Testimonial::get();
        $home_page_item = HomePageItem::where('id', 1)->first();
        $featured_causes = Cause::where('is_featured','Yes')->get();
        $events = Event::get();
        $posts = Post::orderBy('id','desc')->take(3)->get();
        
        return view('front.home',compact('sliders', 'special', 'features', 'testimonials', 'home_page_item', 'featured_causes', 'events', 'posts'));
    }

    public function dashboard()
    {
        $total_ticket = 0;
        $total_price = 0;
        $event_ticket = EventTicket::where('user_id', auth()->user()->id)->get();
        foreach ($event_ticket as $value) {
            $total_ticket += $value->number_of_tickets;
            $total_price += $value->total_price;
        }

        $total_donation_price = 0;
        $donation_data = CauseDonation::where('user_id', auth()->user()->id)->get();
        foreach ($donation_data as $value) {
            $total_donation_price += $value->price;
        }
        return view('front.dashboard',compact('total_ticket', 'total_price', 'total_donation_price'));
    }

    public function terms_conditions()
    {
        $terms = PagePolicy::where('id',1)->first();
        return view('front.terms_condition', compact('terms'));
    }

    public function privacy_policy()
    {
        $privacy = PagePolicy::where('id',1)->first();
        return view('front.privacy_policy', compact('privacy'));        
    }

}
