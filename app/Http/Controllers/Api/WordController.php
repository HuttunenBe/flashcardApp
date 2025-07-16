<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Word;
use Illuminate\Support\Facades\Http;


class WordController extends Controller
{

    public function toggleFavorite($apiWord)
    {
        //Call API and get words data
        $response = Http::withHeaders([
            'x-api-key' => env('FINNFAST_API_KEY'),
            'accept' => 'application/json',
        ])->get("https://finnfast.fi/api/words/$apiWord");


        //Parse JSON response
        $favoritedData = $response->json();

        //Save word in local database but only if it doesn't exist
        $word = Word::firstOrCreate([
            'finnish' => $favoritedData['finnish'],
            'english' => $favoritedData['english'],
            'example' => $favoritedData['example'],
        ]);
        $message = $word->wasRecentlyCreated
            ? "Word has been added to favorites."
            : "Word is already in favorites.";

        return response()->json(['message' => $message], 200);


        return response()->json(null, 200);
    }
}
