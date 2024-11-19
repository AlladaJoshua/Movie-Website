<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $client = new Client();
        // $page = $request->query('page', 1);
        // $response = $client->request('GET', "https://api.themoviedb.org/3/discover/movie?include_adult=false&include_video=false&language=en-US&sort_by=popularity.desc&page={$page}", [
        //     'headers' => [
        //         'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4YjE5YTE3NTliZDYxMjgzZTdkMTEzYTFhNTZlNTMxMiIsIm5iZiI6MTczMDkzODA0OS4xMTUyMzk0LCJzdWIiOiI2NzAxNzIzZmU0ODAxNDkxNDY4NTZkOTIiLCJzY29wZXMiOlsiYXBpX3JlYWQiXSwidmVyc2lvbiI6MX0.l2Ygzr07ca5uK3yZns54tuP-QuNcyeDIFo6AwYJcAAI',
        //         'accept' => 'application/json',
        //     ],
        // ]);


        // $moviesDB = Movie::query()->orderBy('created_at', 'desc')->get();
        // dd($moviesDB);
        // $movies = json_decode($response->getBody(), true);


        // $paginator = new LengthAwarePaginator(
        //     $movies['results'], // Items
        //     $movies['total_results'], // Total items
        //     20, // Per page
        //     $page, // Current page
        //     ['path' => url('/movie')] // URL and query for pagination links
        // );

        // return view('movie.index', ['movies' => $paginator])->with('paginationView', 'vendor.pagination.custom');

        $page = $request->query('page', 1); // Get the current page from the query string
        $perPage = 20; // Number of items per page

        $genreFilter = $request->query('genre');
        // Fetch genres
        $genres = Movie::selectRaw('JSON_UNQUOTE(JSON_EXTRACT(genre_ids, "$[*].name")) as name')
            ->distinct()
            ->get();
        // Fetch movies from the local database, ordered by creation date
        $moviesQuery = Movie::query()->orderBy('id', 'asc');
        if ($genreFilter) {
            $moviesQuery->whereRaw(
                'JSON_CONTAINS(genre_ids, ?)',
                ['{"name": "' . $genreFilter . '"}']
            );
        }
        $totalMovies = $moviesQuery->count(); // Total number of movies
        $movies = $moviesQuery->skip(($page - 1) * $perPage)->take($perPage)->get(); // Paginate manually

        // Create a LengthAwarePaginator instance for the movies
        $paginator = new LengthAwarePaginator(
            $movies, // Items for the current page
            $totalMovies, // Total items
            $perPage, // Items per page
            $page, // Current page
            ['path' => url('/movie')] // URL for pagination links
        );

        // Render the view with the paginated data
        return view('movie.index', [
            'movies' => $paginator,
            'genres' => $genres,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('movie.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {

        $client = new Client();

        // Fetch movie images from TMDB API using the movie's TMDB ID
        $response = $client->request('GET', "https://api.themoviedb.org/3/movie/{$movie->tmdb_id}/images", [
            'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4YjE5YTE3NTliZDYxMjgzZTdkMTEzYTFhNTZlNTMxMiIsIm5iZiI6MTczMDkzODA0OS4xMTUyMzk0LCJzdWIiOiI2NzAxNzIzZmU0ODAxNDkxNDY4NTZkOTIiLCJzY29wZXMiOlsiYXBpX3JlYWQiXSwidmVyc2lvbiI6MX0.l2Ygzr07ca5uK3yZns54tuP-QuNcyeDIFo6AwYJcAAI', // Replace with your TMDB API key
                'Accept' => 'application/json',
            ],
        ]);

        // Decode the response body to get the images
        $images = json_decode($response->getBody()->getContents(), true);

        // Pass the movie data and images to the view
        return view('movie.show', compact('movie', 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        return view('movie.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
