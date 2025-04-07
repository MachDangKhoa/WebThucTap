<?php

namespace App\Http\Controllers\Auth;

use App\Models\PaintingDb;
use App\Models\PaintingGoogle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaintController extends Controller
{
    // Show the paintings from both databases
    public function index()
    {
        $paintingDb = PaintingDb::all();
        $paintingGoogle = PaintingGoogle::all();
        return view('paint.paintings', compact('paintingDb', 'paintingGoogle'));
    }

    // Edit painting from PaintingDb
    public function edit_db($id)
    {
        $painting = PaintingDb::findOrFail($id);
        return view('paint.edit_db', compact('painting'));
    }
    public function update_db(Request $request, $id)
    {
        $request->validate([
            'painting_title' => 'required|string|max:255',
            'artist_db' => 'required|string|max:255',
            'style_db' => 'required|string|max:255',
            'photographer' => 'required|string|max:255',
            'similarity' => 'required|numeric',
            'matched_file' => 'required|string|max:255',
            'description' => 'required|string',
            'img_url_db' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:10240',  // 10MB max
        ]);

        $painting = PaintingDb::findOrFail($id);

        $painting->painting_title = $request->painting_title;
        $painting->artist_db = $request->artist_db;
        $painting->style_db = $request->style_db;
        $painting->photographer = $request->photographer;
        $painting->similarity = $request->similarity;
        $painting->matched_file = $request->matched_file;
        $painting->description = $request->description;

        // Handling the image upload
        if ($request->hasFile('img_url_db')) {
            $image = $request->file('img_url_db');
            $painting->img_url_db = file_get_contents($image);  // Store image as binary data
        }

        $painting->save();

        return redirect()->route('paintings.index')->with('success', 'Painting updated successfully!');
    }

    // Delete painting from PaintingDb
    public function destroy_db($id)
    {
        $painting = PaintingDb::findOrFail($id);
        $painting->delete();
        return redirect()->route('paintings.index');
    }

    // Edit painting from PaintingGoogle
    public function edit_google($id)
    {
        $painting = PaintingGoogle::findOrFail($id);
        return view('edit_painting', compact('painting'));
    }

    public function update_google(Request $request, $id)
    {
        $request->validate([
            'title_gg' => 'required|string|max:255',
            'artist_gg' => 'required|string|max:255',
            'style_gg' => 'required|string|max:255',
            'genre_gg' => 'required|string|max:255',
            'year_gg' => 'required|date',  // You can still validate this field but make it non-editable in the form
            'description_gg' => 'required|string',
            'artistic_features_gg' => 'required|string',
            'additional_info_gg' => 'required|string',
            'img_url_gg' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:10240',  // 10MB max
        ]);

        $painting = PaintingGoogle::findOrFail($id);

        $painting->title_gg = $request->title_gg;
        $painting->artist_gg = $request->artist_gg;
        $painting->style_gg = $request->style_gg;
        $painting->genre_gg = $request->genre_gg;
        $painting->year_gg = $request->year_gg;  // This will be updated via form if necessary
        $painting->description_gg = $request->description_gg;
        $painting->artistic_features_gg = $request->artistic_features_gg;
        $painting->additional_info_gg = $request->additional_info_gg;

        // Handling the image upload
        if ($request->hasFile('img_url_gg')) {
            $image = $request->file('img_url_gg');
            $painting->img_url_gg = file_get_contents($image);  // Store image as binary data
        }

        $painting->save();

        return redirect()->route('paintinggoogle.index')->with('success', 'Painting updated successfully!');
    }

    // Delete painting from PaintingGoogle
    public function destroy_google($id)
    {
        $painting = PaintingGoogle::findOrFail($id);
        $painting->delete();
        return redirect()->route('paintings.index');
    }

}
