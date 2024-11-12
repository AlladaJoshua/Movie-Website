<x-layout>

    {{-- Search Bar Component --}}

    {{-- <div class="input-container" onclick="toggleActive(this)">
        <label for="search">Search</label>
        <input type="text" name="search" id="search" class="hidden-input" />
    </div> --}}

    {{-- Search Bar Component --}}

    <div class="content">
        @if ($movies->count())
            <ul class="movie-poster-container">
                @foreach ($movies as $movie)
                    <li class="movie-content">
                        @if ($movie['poster_path'])
                            <img src="https://image.tmdb.org/t/p/w200{{ $movie['poster_path'] }}"
                                alt="{{ $movie['title'] }} Poster">
                        @else
                            <img src="https://via.placeholder.com/200x300?text=No+Image" alt="No Image">
                        @endif

                        <div class="movie-title">
                            <strong>{{ $movie['title'] }}</strong>
                        </div>
                        <div class="movie-date">
                            {{-- Format the release date --}}
                            {{ \Carbon\Carbon::parse($movie['release_date'])->format('Y') }}
                        </div>
                    </li>
                @endforeach
            </ul>
            {{ $movies->links('vendor.pagination.custom') }}
        @else
            <p>No movies found for "{{ $query }}".</p>
        @endif
    </div>
</x-layout>
