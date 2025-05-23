<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Word;
use Illuminate\Support\Facades\Http;


class WordController extends Controller
{

    public function words($apiWord)
    {

        $response = Http::withHeaders([
            'x-api-key' => env('FINNFAST_API_KEY'),
            'accept' => 'application/json',
        ])->get("https://finnfast.fi/api/words/$apiWord");



        $favoritedData = $response->json();

        $favoritedData = Word::firstOrCreate([
            'finnish' => $favoritedData['finnish'],
            'english' => $favoritedData['english'],
            'example' => $favoritedData['example'],
        ]);



        return response()->json(null, 204);
    }
}
