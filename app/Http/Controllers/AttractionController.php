<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use App\Models\AttractionReview;
use App\Models\Hotel;
use Illuminate\Http\Request;


class AttractionController extends Controller
{
    public function index(Request $request)
    {
        $query = Attraction::with(['images', 'reviews'])
            ->withAvg('reviews', 'rating');

        // Поиск
        if ($request->has('search')) {
            $query->where('title', 'like', "%{$request->search}%")
                ->orWhere('description', 'like', "%{$request->search}%")
                ->orWhere('short_description', 'like', "%{$request->search}%");
        }

        // Сортировка
        $sortBy = $request->get('sort_by', 'rating');
        $sortOrder = $request->get('sort_order', 'desc');

        if ($sortBy === 'rating') {
            $query->orderBy('reviews_avg_rating', $sortOrder);
        } elseif ($sortBy === 'popularity') {
            $query->withCount('reviews')->orderBy('reviews_count', $sortOrder);
        }

        $attractions = $query->paginate(10);

        return view('attractions.index', compact('attractions'));
    }

    public function show(Attraction $attraction)
    {
        $attraction->load(['images', 'reviews'])
            ->loadAvg('reviews', 'rating')
            ->loadCount('reviews');

        $reviews = $attraction->reviews()->paginate(10);

        return view('attractions.show', [
            'attraction' => $attraction,
            'reviews' => $reviews
        ]);
    }

    public function review(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'name' => 'required|string',
            'comment' => 'required|string|max:1000',
            'attraction_id' => 'required|exists:attractions,id'
        ]);

        $ip = $request->ip();

        if (AttractionReview::where('attraction_id', $request->attraction_id)
            ->where('ip', $ip)
            ->exists()) {
            return back()->withErrors(['message' => 'Вы уже оставляли отзыв']);
        }

        AttractionReview::create([
            'attraction_id' => $request->attraction_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'name' => $request->name,
            'ip' => $ip
        ]);

        return redirect()->route('attractions.show', $request->attraction_id);
    }
}
