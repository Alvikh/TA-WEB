<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class BroadcastController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('emails.broadcast', compact('users'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $users = User::whereNotNull('email')->get();

        if ($users->isEmpty()) {
            return back()->with('error', 'Tidak ada user dengan email yang valid.');
        }

        foreach ($users as $user) {
            Mail::send('emails.message', [
                'user' => $user,
                'messageContent' => $request->message,
                'dynamicContent' => $request->message
            ], function ($mail) use ($user, $request) {
                $mail->to($user->email)
                    ->subject($request->subject);
            });
        }

        return back()->with('success', 'Broadcast email berhasil dikirim ke semua user.');
    }

    public function sendSelected(Request $request)
    {
        $request->validate([
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $selectedUsers = User::whereIn('id', $request->users)->get();

        foreach ($selectedUsers as $user) {
            Mail::send('emails.message', [
                'user' => $user,
                'messageContent' => $request->message,
                'dynamicContent' => $request->message
            ], function ($mail) use ($user, $request) {
                $mail->to($user->email)
                    ->subject($request->subject);
            });
        }

        return back()->with('success', 'Broadcast email berhasil dikirim ke user terpilih.');
    }
}