<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(string $visitorId)
    {
        $messages = Message::where('visitor_id', $visitorId)
            ->orderBy('created_at')
            ->get(['id', 'sender', 'visitor_name', 'body', 'created_at']);

        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'visitor_id'   => 'required|string|max:64',
            'visitor_name' => 'nullable|string|max:100',
            'body'         => 'required|string|max:2000',
        ]);

        $message = Message::create([
            'visitor_id'   => $validated['visitor_id'],
            'visitor_name' => $validated['visitor_name'] ?? null,
            'sender'       => 'visitor',
            'body'         => $validated['body'],
        ]);

        return response()->json($message, 201);
    }
}
