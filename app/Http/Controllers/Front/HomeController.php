<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Experience;
use App\Models\PersonalInfo;
use App\Models\Portfolio;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\SocialLink;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $info = PersonalInfo::first() ?? new PersonalInfo();
        $settings = Setting::current();

        $experiences = Experience::active()->ordered()->get();
        $educations  = Education::active()->ordered()->get();
        $testimonials = Testimonial::active()->ordered()->get();
        $socials     = SocialLink::active()->ordered()->get();

        $skills = Skill::active()
            ->ordered()
            ->get()
            ->groupBy(fn (Skill $skill) => $skill->t('category'));

        $portfolios = Portfolio::active()->ordered()->get();

        $portfolioCategories = $portfolios
            ->map(fn (Portfolio $item) => $item->t('category'))
            ->filter()
            ->unique()
            ->values();

        return view('front.home', get_defined_vars());
    }
}
