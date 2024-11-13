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
                            <div class="image-container">
                                <img src="https://image.tmdb.org/t/p/w200{{ $movie['poster_path'] }}"
                                    alt="{{ $movie['title'] }} Poster">
                                <div class="overlay">
                                    <svg class="play-button" width="100" height="100" viewBox="0 0 48 48" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="24" cy="24" r="23.5" fill="black" fill-opacity="0.3"
                                            stroke="white" />
                                        <path
                                            d="M37.7883 22.5825C38.9332 23.1811 38.9332 24.8196 37.7883 25.4182L17.3414 36.1094C16.2761 36.6664 15 35.8937 15 34.6915L15 24.0003L15 13.3091C15 12.107 16.2761 11.3342 17.3414 11.8912L37.7883 22.5825Z"
                                            fill="white" />
                                    </svg>
                                </div>
                            </div>
                        @else
                            <img src="https://via.placeholder.com/200x300?text=No+Image" alt="No Image">
                        @endif

                        <div class="movie-details">
                            <div class="movie-title">
                                <strong>{{ $movie['title'] }}</strong>
                            </div>
                            <div class="movie-date">
                                {{-- Format the release date --}}
                                {{ \Carbon\Carbon::parse($movie['release_date'])->format('Y') }}
                            </div>
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
