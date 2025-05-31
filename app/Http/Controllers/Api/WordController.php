<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Word;
use Illuminate\Support\Facades\Http;


class WordController extends Controller
{

    public function saveFavorite($apiWord)
    {
        //Call API and get words data
        $response = Http::withHeaders([
            'x-api-key' => env('FINNFAST_API_KEY'),
            'accept' => 'application/json',
        ])->get("https://finnfast.fi/api/words/$apiWord");


        //Parse JSON response
        $favoritedData = $response->json();

        //Save word in local database but only if it doesn't exist
        $favoritedData = Word::firstOrCreate([
            'finnish' => $favoritedData['finnish'],
            'english' => $favoritedData['english'],
            'example' => $favoritedData['example'],


        ]);



        return response()->json(null, 200);
    }
}
