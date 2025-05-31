<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NameColor;
use Illuminate\Http\Request;

class NameColorController extends Controller
{
    // return name_color entries from database
    public function index()
    {
        return NameColor::all();
    }

    // Store new entry
    public function store(Request $request)
    {
        // Input validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:50',
        ]);
        // Save to database
        $nameColor = NameColor::create($validated);
        // Return object
        return response()->json($nameColor, 201);
    }

    public function show($id)
    {
        return NameColor::findOrFail($id);
    }

    // Update infomation in database
    public function update(Request $request, $id)
    {
        $nameColor = NameColor::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'color' => 'sometimes|string|max:50',
        ]);

        $nameColor->update($validated);
        return response()->json($nameColor); // Return updated object
    }

    // Delete from database
    public function destroy($id)
    {
        $nameColor = NameColor::findOrFail($id);
        $nameColor->delete();
        return response()->json(null, 204);
    }
}
