<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    // Liste des conversations, la plus récente en premier
    public function index()
    {
        $conversations = Message::selectRaw('visitor_id, MAX(created_at) as last_message_at')
            ->groupBy('visitor_id')
            ->orderByDesc('last_message_at')
            ->get()
            ->map(function ($row) {
                $last = Message::where('visitor_id', $row->visitor_id)->latest()->first();
                $unread = Message::where('visitor_id', $row->visitor_id)
                    ->where('sender', 'visitor')
                    ->whereNull('read_at')
                    ->count();

                return (object) [
                    'visitor_id'      => $row->visitor_id,
                    'visitor_name'    => $last->visitor_name ?: 'Visiteur',
                    'last_message'    => $last->body,
                    'last_message_at' => $row->last_message_at,
                    'unread'          => $unread,
                ];
            });

        return view('admin.inbox.index', compact('conversations'));
    }

    // Ouvre une conversation et marque comme lu
    public function show(string $visitorId)
    {
        $messages = Message::where('visitor_id', $visitorId)->orderBy('created_at')->get();

        Message::where('visitor_id', $visitorId)
            ->where('sender', 'visitor')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('admin.inbox.show', compact('messages', 'visitorId'));
    }

    // Rafraîchissement automatique en JSON
    public function poll(string $visitorId)
    {
        $messages = Message::where('visitor_id', $visitorId)
            ->orderBy('created_at')
            ->get(['id', 'sender', 'visitor_name', 'body', 'created_at']);

        return response()->json($messages);
    }

    // Toi qui réponds
    public function reply(Request $request, string $visitorId)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        Message::create([
            'visitor_id' => $visitorId,
            'sender'     => 'admin',
            'body'       => $validated['body'],
        ]);

        return back();
    }
}
