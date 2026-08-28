<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {
        $items = Message::latest()->get();

        return view('admin.messages.index', compact('items'));
    }

    public function show(Message $message)
    {
        // با باز کردن پیام، خوانده‌شده علامت می‌خورد
        if (! $message->is_read) {
            $message->update(['is_read' => true, 'read_at' => now()]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'پیام حذف شد.');
    }
}
