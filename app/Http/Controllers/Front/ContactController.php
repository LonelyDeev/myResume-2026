<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:120'],
            'email'   => ['required', 'email', 'max:150'],
            'mobile'   => ['regex:/(09)[0-9]{9}/','digits:11'],
            'subject' => ['nullable', 'string', 'max:200'],
            'message' => ['required', 'string', 'max:5000'],
        ], [
            'name.required'    => __('app.validation.name'),
            'email.required'   => __('app.validation.email'),
            'mobile.required'   => __('app.validation.mobile'),
            'email.email'      => __('app.validation.email_invalid'),
            'message.required' => __('app.validation.message'),
        ]);

        Message::create($validated);

        return redirect()
            ->to(route('home', ['locale' => app()->getLocale()]) . '#contact')
            ->with('contact_success', __('app.contact.success'));
    }
}
