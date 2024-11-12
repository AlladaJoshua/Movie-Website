<x-layout>

    {{-- Search Bar Component --}}

    {{-- <div class="input-container" onclick="toggleActive(this)">
        <label for="search">Search</label>
        <input type="text" name="search" id="search" class="hidden-input" />
    </div> --}}

    {{-- Search Bar Component --}}

    <div class="content">
        @if ($movies->count())
            <ul style="list-style-type: none; padding: 0;">
                @foreach ($movies as $movie)
                    <li style="margin-bottom: 20px; display: flex; align-items: center;">
                        @if ($movie['poster_path'])
                            <img src="https://image.tmdb.org/t/p/w200{{ $movie['poster_path'] }}"
                                alt="{{ $movie['title'] }} Poster" style="margin-right: 20px;">
                        @else
                            <img src="https://via.placeholder.com/200x300?text=No+Image" alt="No Image"
                                style="margin-right: 20px;">
                        @endif

                        <div>
                            <strong>{{ $movie['title'] }}</strong> - Released: {{ $movie['release_date'] }}
                            <p>{{ $movie['overview'] }}</p>
                            <img src="https://image.tmdb.org/t/p/w200{{ $movie['backdrop_path'] }}"
                                alt="{{ $movie['title'] }} Poster" style="margin-right: 20px;">
                        </div>
                    </li>
                @endforeach
            </ul>

            <div>
                {{ $movies->links('vendor.pagination.custom') }}
            </div>
        @else
            <p>No movies found for "{{ $query }}".</p>
        @endif
    </div>
</x-layout>
