<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Word;
use Illuminate\Http\Request;

     class WordController extends Controller

     
     {
         public function index()
         {
             return Word::all();
         }

         public function store(Request $request)
         {
             $validated = $request->validate([
                'finnish' => 'required|string',
            'english' => 'required|string',
            'example' => 'nullable|string',
             ]);

             $nameColor = Word::create($validated);
             return response()->json($nameColor, 201);
         }

         public function show($id)
         {
             return Word::findOrFail($id);
         }

   

     
     }