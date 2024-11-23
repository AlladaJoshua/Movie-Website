<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

class AdminMovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->query('page', 1); // Current page
        $perPage = 20; // Items per page

        $genreFilter = $request->query('genre');

        // Fetch unique genres
        $genres = Movie::selectRaw('JSON_UNQUOTE(JSON_EXTRACT(genre_ids, "$[*].name")) as name')
            ->distinct()
            ->get();

        // Fetch movies with optional genre filtering
        $moviesQuery = Movie::query()->orderBy('id', 'asc');
        if ($genreFilter) {
            $moviesQuery->whereRaw(
                'JSON_CONTAINS(genre_ids, ?)',
                [json_encode([['name' => $genreFilter]])]
            );
        }

        // Get total movie count and paginated data
        $totalMovies = $moviesQuery->count();
        $movies = $moviesQuery->skip(($page - 1) * $perPage)->take($perPage)->get();

        // Create paginator
        $paginator = new LengthAwarePaginator(
            $movies,
            $totalMovies,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()] // Preserve query parameters
        );

        // Render the view
        return view('admin.movies.index', [
            'movies' => $paginator,
            'genres' => $genres,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.movies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tmdb_id' => 'required|integer|unique:movies,tmdb_id',
            'title' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'overview' => 'nullable|string',
            'poster_path' => 'nullable|string', // Poster path from external URL
            'background_path' => 'nullable|string|max:255',
            'vote_average' => 'nullable|numeric',
            'genre_ids' => 'nullable|json',
            'runtime' => 'nullable|integer',
            'subtitle_link' => 'nullable|string|max:255',
            'vote_count' => 'nullable|integer',
        ]);

        // Handle poster image from external URL
        $posterFileName = null;
        if ($request->has('poster_path')) {
            $posterUrl = 'https://image.tmdb.org/t/p/w500/' . $request->input('poster_path');
            
            // Create a Guzzle client instance
            $client = new Client();

            try {
                // Get the image content using Guzzle
                $imageResponse = $client->get($posterUrl);
                $imageContent = $imageResponse->getBody();

                // Generate a unique file name
                $posterFileName = basename($posterUrl);

                // Store the image in 'poster_folder' directory
                Storage::disk('public')->put('poster_folder/' . $posterFileName, $imageContent);

            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to fetch image from the URL'], 500);
            }
        }

        try {
            // Save movie data with the actual file name of the poster
            Movie::create([
                'tmdb_id' => $request->tmdb_id,
                'title' => $request->title,
                'tagline' => $request->tagline,
                'release_date' => $request->release_date,
                'overview' => $request->overview,
                'poster_path' => $posterFileName, // Save the file name of the poster image
                'background_path' => $request->background_path,
                'vote_average' => $request->vote_average,
                'genre_ids' => $request->genre_ids,
                'runtime' => $request->runtime,
                'subtitle_link' => $request->subtitle_link,
                'vote_count' => $request->vote_count,
            ]);

            return response()->json(['message' => 'Movie uploaded successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to save movie: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.movies.edit', compact('movie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $movie = Movie::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'overview' => 'nullable|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Poster validation
            'background_path' => 'nullable|string|max:255',
            'vote_average' => 'nullable|numeric',
            'genre_ids' => 'nullable|json',
            'runtime' => 'nullable|integer',
            'subtitle_link' => 'nullable|string|max:255',
            'vote_count' => 'nullable|integer',
        ]);

        // Handle file upload for the poster
        if ($request->hasFile('poster') && $request->file('poster')->isValid()) {
            // Delete the old poster if it exists
            if ($movie->poster_path && Storage::exists('public/poster_folder/' . $movie->poster_path)) {
                Storage::delete('public/poster_folder/' . $movie->poster_path);
            }

            $poster = $request->file('poster');
            $posterName = time() . '_' . $poster->getClientOriginalName(); // Generate a unique name for the file
            $poster->storeAs('public/poster_folder', $posterName); // Store new poster
        } else {
            $posterName = $movie->poster_path; // Keep the old poster file name if no new file is uploaded
        }

        try {
            // Update movie details
            $movie->update([
                'title' => $request->title,
                'tagline' => $request->tagline,
                'release_date' => $request->release_date,
                'overview' => $request->overview,
                'poster_path' => $posterName, // Save only the file name in the database
                'background_path' => $request->background_path,
                'vote_average' => $request->vote_average,
                'genre_ids' => $request->genre_ids,
                'runtime' => $request->runtime,
                'subtitle_link' => $request->subtitle_link,
                'vote_count' => $request->vote_count,
            ]);

            return response()->json(['message' => 'Movie updated successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update movie: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movie = Movie::findOrFail($id);

        // Delete the movie poster file from storage if it exists
        if ($movie->poster_path && Storage::exists('public/poster_folder/' . $movie->poster_path)) {
            Storage::delete('public/poster_folder/' . $movie->poster_path);
        }

        // Delete the movie record
        $movie->delete();

        return response()->json(['message' => 'Movie deleted successfully!'], 200);
    }
}
