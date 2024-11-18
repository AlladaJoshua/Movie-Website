<x-layout>
    <div class="content-show">
        <div class="container">
            <div class="video-contianer">
                <!-- Backdrop image fetched from TMDB -->
                @if (isset($images['backdrops']) && count($images['backdrops']) > 0)
                    <div class="video-backdrop"
                        style="background-image: url('https://image.tmdb.org/t/p/w500/{{ $images['backdrops'][0]['file_path'] }}');">
                    </div>
                @else
                    <div class="video-backdrop" style="background-color: black;"></div> <!-- Default black background -->
                @endif

                <!-- Play Button -->
                <button class="play-button" id="play-button">
                    <svg width="100" height="100" viewBox="0 0 48 48" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle cx="24" cy="24" r="23.5" fill="black" fill-opacity="0.3"
                            stroke="white" />
                        <path
                            d="M37.7883 22.5825C38.9332 23.1811 38.9332 24.8196 37.7883 25.4182L17.3414 36.1094C16.2761 36.6664 15 35.8937 15 34.6915L15 24.0003L15 13.3091C15 12.107 16.2761 11.3342 17.3414 11.8912L37.7883 22.5825Z"
                            fill="white" />
                    </svg>
                </button>

                <!-- Video Player -->
                <video id="movie-video" src="{{ Storage::url('movie_folder/' . $movie->path_movie) }}" preload="none"
                    controls></video>
            </div>

            <div class="movie-selected-details">
                <div class="left">
                    <img class="movie-poster-selected" src="{{ Storage::url('poster_folder/' . $movie->poster_path) }}"
                        alt="{{ $movie->title }}">
                    <h1 class="show_title">{{ $movie->title }}</h1>
                    <div class="movie_selected_genre">
                        <ul class="genre">
                            @foreach (json_decode($movie->genre_ids, true) as $genre)
                                <li>{{ $genre['name'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="overview">
                        <h4>Overview:</h4>
                        <p>{{ $movie->overview }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
