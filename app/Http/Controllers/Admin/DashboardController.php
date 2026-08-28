<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Portfolio;
use App\Models\Skill;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'experiences'  => Experience::count(),
            'educations'   => Education::count(),
            'skills'       => Skill::count(),
            'portfolios'   => Portfolio::count(),
            'testimonials' => Testimonial::count(),
            'unread'       => Message::unread()->count(),
        ];

        $latestMessages = Message::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'latestMessages'));
    }
}
