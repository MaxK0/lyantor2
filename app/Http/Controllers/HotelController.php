<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelReview;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $query = Hotel::with(['images', 'reviews'])
            ->withAvg('reviews', 'rating');

        if ($request->has('search')) {
            $query->where('title', 'like', "%{$request->search}%")
                ->orWhere('description', 'like', "%{$request->search}%");
        }

        $sortBy = $request->get('sort_by', 'rating');
        $sortOrder = $request->get('sort_order', 'desc');

        if ($sortBy === 'rating') {
            $query->orderBy('reviews_avg_rating', $sortOrder);
        } elseif ($sortBy === 'popularity') {
            $query->withCount('reviews')->orderBy('reviews_count', $sortOrder);
        }

        $hotels = $query->paginate(10);

        return view('hotels.index', compact('hotels'));
    }

    public function show(Hotel $hotel)
    {
        $hotel->load(['images', 'reviews'])
            ->loadAvg('reviews', 'rating')
            ->loadCount('reviews');

        $reviews = $hotel->reviews()->paginate(10);

        return view('hotels.show', [
            'hotel' => $hotel,
            'reviews' => $reviews
        ]);
    }

    public function review(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'name' => 'required|string',
            'comment' => 'required|string|max:1000',
            'hotel_id' => 'required|exists:hotels,id'
        ]);

        $ip = $request->ip();

        if (HotelReview::where('hotel_id', $request->hotel_id)
            ->where('ip', $ip)
            ->exists()) {
            return back()->withErrors(['message' => 'Вы уже оставляли отзыв']);
        }

        HotelReview::create([
            'hotel_id' => $request->hotel_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'name' => $request->name,
            'ip' => $ip
        ]);

        return redirect()->route('hotels.show', $request->hotel_id);
    }
}
