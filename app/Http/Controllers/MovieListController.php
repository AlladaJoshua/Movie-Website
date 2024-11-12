<?php

namespace App\Http\Controllers;

use App\Models\movie;
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
        $client = new Client();
        $page = $request->query('page', 1);
        $response = $client->request('GET', "https://api.themoviedb.org/3/discover/movie?include_adult=false&include_video=false&language=en-US&sort_by=popularity.desc&page={$page}", [
            'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4YjE5YTE3NTliZDYxMjgzZTdkMTEzYTFhNTZlNTMxMiIsIm5iZiI6MTczMDkzODA0OS4xMTUyMzk0LCJzdWIiOiI2NzAxNzIzZmU0ODAxNDkxNDY4NTZkOTIiLCJzY29wZXMiOlsiYXBpX3JlYWQiXSwidmVyc2lvbiI6MX0.l2Ygzr07ca5uK3yZns54tuP-QuNcyeDIFo6AwYJcAAI',
                'accept' => 'application/json',
            ],
        ]);

        $movies = json_decode($response->getBody(), true);

        $paginator = new LengthAwarePaginator(
            $movies['results'], // Items
            $movies['total_results'], // Total items
            20, // Per page
            $page, // Current page
            ['path' => url('/movie')] // URL and query for pagination links
        );
        
        return view('movie.index', ['movies' => $paginator]);
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
    public function show(movie $movie)
    {
        return view('movie.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(movie $movie)
    {
        return view('movie.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(movie $movie)
    {
        //
    }
}
