<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Hotel;

class BookmarkController extends Controller
{
    public function index()
    {
        $hotels = auth()->user()
            ->savedHotels()
            ->latest()
            ->get();

        return view('user.bookmark.index', compact('hotels'));
    }

    public function store(Hotel $hotel)
    {
        auth()->user()->savedHotels()->syncWithoutDetaching($hotel->id);

        return response()->json(['status' => 'saved']);
    }

    public function destroy(Hotel $hotel)
    {
        auth()->user()->savedHotels()->detach($hotel->id);

        return response()->json(['status' => 'removed']);
    }
}
