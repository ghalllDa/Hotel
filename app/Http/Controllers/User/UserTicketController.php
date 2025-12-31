<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class UserTicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::whereHas('booking', function ($q) {
            $q->where('user_id', Auth::id());
        })->latest()->get();

        return view('user.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        abort_if($ticket->booking->user_id !== Auth::id(), 403);

        return view('user.tickets.show', compact('ticket'));
    }
}
