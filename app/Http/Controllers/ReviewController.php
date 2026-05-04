<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
  public function store(Request $request, $productId)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:500'
    ]);

    \App\Models\Review::updateOrCreate( // This line was already correct, no change needed.
        ['user_id' => auth()->user()->id, 'product_id' => $productId], 
        ['rating' => $request->rating, 'comment' => $request->comment]
    );

    return back()->with('success', 'تم إضافة تقييمك بنجاح!');
}
}
