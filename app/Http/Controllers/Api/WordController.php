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
        // Call external API to get word data by apiWord (external ID)
        $response = Http::withHeaders([
            'x-api-key' => env('FINNFAST_API_KEY'),
            'accept' => 'application/json',
        ])->get("https://finnfast.fi/api/words/$apiWord");

        $favoritedData = $response->json();

        // Save word in local DB, including api_id
        $word = Word::firstOrCreate([
            'api_id' => $apiWord,
            'finnish' => $favoritedData['finnish'],
            'english' => $favoritedData['english'],
            'example' => $favoritedData['example'],
        ]);

        $message = $word->wasRecentlyCreated
            ? "Word has been added to favorites."
            : "Word is already in favorites.";

        return response()->json(['message' => $message], 200);
    }

    public function destroy($apiId)
    {

        $word = Word::where('api_id', $apiId)->first();

        if (!$word) {
            return response()->json(['message' => 'Word not found.'], 404);
        }

        $word->delete();

        return response()->json(['message' => 'Word deleted from favorites.'], 200);
    }
}
