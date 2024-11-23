<x-app-layout>
    <div class="admin-container">
        <h1>Movies</h1>
        <div class="admin-container-forms">
            <form id="movie-form" class="space-y-4">
                @csrf

                <!-- Movie Search -->
                <div class="relative">
                    <label for="tmdb_search" class="block text-gray-700 font-medium">Search Movie by Name</label>
                    <input type="text" class="w-full border border-gray-300 rounded p-2" id="tmdb_search"
                        name="tmdb_search" placeholder="Search for a movie" onkeyup="searchMovie()" autocomplete="off">
                    <!-- Dropdown for search results -->
                    <div id="search_results"
                        class="absolute left-0 right-0 mt-2 bg-white border border-gray-300 rounded shadow-lg hidden">
                    </div>
                </div>

                <!-- Hidden TMDB ID -->
                <div>
                    <input type="hidden" id="tmdb_id" name="tmdb_id">
                </div>

                <!-- Metadata Fields -->
                <div>
                    <label for="title" class="block text-gray-700 font-medium">Title</label>
                    <input type="text" class="w-full border border-gray-300 rounded p-2" id="title"
                        name="title" value="{{ old('title') }}" required>
                </div>

                <!-- Overview -->
                <div>
                    <label for="overview" class="block text-gray-700 font-medium">Overview</label>
                    <textarea class="w-full border border-gray-300 rounded p-2" id="overview" name="overview" rows="4">{{ old('overview') }}</textarea>
                </div>

                <div>
                    <label for="release_date" class="block text-gray-700 font-medium">Release Date</label>
                    <input type="date" class="w-full border border-gray-300 rounded p-2" id="release_date"
                        name="release_date" value="{{ old('release_date') }}">
                </div>

                <div>
                    <label for="tagline" class="block text-gray-700 font-medium">Tagline</label>
                    <input type="text" class="w-full border border-gray-300 rounded p-2" id="tagline"
                        name="tagline" value="{{ old('tagline') }}">
                </div>

                <div>
                    <label for="poster_path" class="block text-gray-700 font-medium">Poster Path</label>
                    <input type="text" class="w-full border border-gray-300 rounded p-2" id="poster_path"
                        name="poster_path" value="{{ old('poster_path') }}">
                </div>

                <div>
                    <label for="background_path" class="block text-gray-700 font-medium">Background Path</label>
                    <input type="text" class="w-full border border-gray-300 rounded p-2" id="background_path"
                        name="background_path" value="{{ old('background_path') }}">
                </div>

                <div>
                    <label for="vote_average" class="block text-gray-700 font-medium">Vote Average</label>
                    <input type="number" step="0.1" class="w-full border border-gray-300 rounded p-2"
                        id="vote_average" name="vote_average" value="{{ old('vote_average') }}">
                </div>

                <div>
                    <label for="genre_ids" class="block text-gray-700 font-medium">Genre IDs</label>
                    <input type="text" class="w-full border border-gray-300 rounded p-2" id="genre_ids"
                        name="genre_ids" value="{{ old('genre_ids') }}">
                </div>

                <div>
                    <label for="runtime" class="block text-gray-700 font-medium">Runtime (minutes)</label>
                    <input type="number" class="w-full border border-gray-300 rounded p-2" id="runtime"
                        name="runtime" value="{{ old('runtime') }}">
                </div>

                <div>
                    <label for="subtitle_link" class="block text-gray-700 font-medium">Subtitle Link</label>
                    <input type="url" class="w-full border border-gray-300 rounded p-2" id="subtitle_link"
                        name="subtitle_link" value="{{ old('subtitle_link') }}">
                </div>

                <div>
                    <label for="vote_count" class="block text-gray-700 font-medium">Vote Count</label>
                    <input type="number" class="w-full border border-gray-300 rounded p-2" id="vote_count"
                        name="vote_count" value="{{ old('vote_count') }}">
                </div>

                <div>
                    <button type="button" onclick="submitForm()"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Function to handle movie search as the user types
        function searchMovie() {
            const query = document.getElementById('tmdb_search').value;

            if (query.length >= 3) { // Only start search after at least 3 characters
                document.getElementById('search_results').innerHTML = 'Loading...';
                document.getElementById('search_results').classList.remove('hidden');

                const options = {
                    method: 'GET',
                    headers: {
                        accept: 'application/json',
                        Authorization: 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4YjE5YTE3NTliZDYxMjgzZTdkMTEzYTFhNTZlNTMxMiIsIm5iZiI6MTczMDkzODA0OS4xMTUyMzk0LCJzdWIiOiI2NzAxNzIzZmU0ODAxNDkxNDY4NTZkOTIiLCJzY29wZXMiOlsiYXBpX3JlYWQiXSwidmVyc2lvbiI6MX0.l2Ygzr07ca5uK3yZns54tuP-QuNcyeDIFo6AwYJcAAI' // Replace with your actual API key
                    }
                };

                fetch(`https://api.themoviedb.org/3/search/movie?include_adult=false&language=en-US&query=${query}&page=1`,
                        options)
                    .then(response => response.json())
                    .then(data => {
                        let results = '';
                        if (data.results.length === 0) {
                            results = '<div class="p-2 text-gray-500">No results found.</div>';
                        } else {
                            data.results.forEach(movie => {
                                results += `
                                    <div class="cursor-pointer p-2 hover:bg-gray-100" onclick="selectMovie(${movie.id})">
                                        <img src="https://image.tmdb.org/t/p/w92${movie.poster_path}" alt="${movie.title}" class="inline-block mr-2" />
                                        <p class="font-bold">${movie.title}</p>
                                        <p class="text-sm text-gray-500">${movie.release_date}</p>
                                    </div>
                                `;
                            });
                        }
                        document.getElementById('search_results').innerHTML = results;
                        document.getElementById('search_results').classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Error fetching movies:', error);
                    });
            } else {
                document.getElementById('search_results').innerHTML = '';
                document.getElementById('search_results').classList.add('hidden');
            }
        }

        // Function to handle movie selection and auto-fill the form
        function selectMovie(id) {
            const options = {
                method: 'GET',
                headers: {
                    accept: 'application/json',
                    Authorization: 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4YjE5YTE3NTliZDYxMjgzZTdkMTEzYTFhNTZlNTMxMiIsIm5iZiI6MTczMDkzODA0OS4xMTUyMzk0LCJzdWIiOiI2NzAxNzIzZmU0ODAxNDkxNDY4NTZkOTIiLCJzY29wZXMiOlsiYXBpX3JlYWQiXSwidmVyc2lvbiI6MX0.l2Ygzr07ca5uK3yZns54tuP-QuNcyeDIFo6AwYJcAAI' // Replace with your actual API key
                }
            };

            fetch(`https://api.themoviedb.org/3/movie/${id}?language=en-US`, options)
                .then(response => response.json())
                .then(movieData => {
                    document.getElementById('tmdb_search').value = movieData.title;
                    document.getElementById('title').value = movieData.title;
                    document.getElementById('release_date').value = movieData.release_date;
                    document.getElementById('tagline').value = movieData.tagline;

                    // Trim the leading slash from poster_path and background_path
                    const posterPath = movieData.poster_path ? movieData.poster_path.replace(/^\/+/, '') : '';
                    const backgroundPath = movieData.backdrop_path ? movieData.backdrop_path.replace(/^\/+/, '') : '';

                    document.getElementById('poster_path').value = posterPath;
                    document.getElementById('background_path').value = backgroundPath;
                    document.getElementById('vote_average').value = movieData.vote_average;
                    document.getElementById('runtime').value = movieData.runtime;
                    document.getElementById('subtitle_link').value = '';
                    document.getElementById('vote_count').value = movieData.vote_count;
                    document.getElementById('tmdb_id').value = movieData.id;

                    // Add the overview to the form
                    document.getElementById('overview').value = movieData.overview;

                    // Map genres to {id, name} and store as a JSON string
                    const genres = movieData.genres.map(genre => ({
                        id: genre.id,
                        name: genre.name
                    }));
                    document.getElementById('genre_ids').value = JSON.stringify(genres); // Store as JSON string

                    document.getElementById('search_results').classList.add('hidden');
                })
                .catch(error => {
                    console.error('Error fetching movie details:', error);
                });
        }



        // Function to handle form submission
        function submitForm() {
            // Get the form data
            const formData = new FormData(document.getElementById('movie-form'));

            // Create a new XMLHttpRequest
            const xhr = new XMLHttpRequest();

            // Handle the response
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert('Movie details saved successfully!');
                } else {
                    alert('Saving failed. Please try again.');
                }
            };

            // Handle errors
            xhr.onerror = function() {
                alert('An error occurred. Please try again.');
            };

            // Send the form data
            xhr.open('POST', '/admin/movies', true);
            xhr.send(formData);
        }
    </script>
</x-app-layout>
