<x-app-layout>
    <div class="admin-container">
        <a href="{{ route('admin.movies.create') }}" class="add_btn">Add Movies</a>
        @if ($movies->count())
            <table>
                <tr>
                    <th>Poster</th>
                    <th>Title</th>
                    <th>Release Date</th>
                    <th>Genre</th>
                </tr>
                @foreach ($movies as $movie)
                    <tr>
                        <td class="table_poster">
                            <div class="image-container">
                                <img src="{{ Storage::url('poster_folder/' . $movie['poster_path']) }}"
                                    alt="{{ $movie['title'] }} Poster">
                            </div>
                        </td>
                        <td>{{ $movie['title'] }}</td>
                        <td>{{ $movie['release_date'] }}</td>
                        <td>
                            <ul class="table_genre">
                                @foreach (json_decode($movie->genre_ids, true) as $genre)
                                    <li>{{ $genre['name'] }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </table>

            <!-- Pagination Links -->
            <div class="pagination-container">
                {{ $movies->links('vendor.pagination.custom') }}
            </div>
        @else
            <p>No movies found for @if ($query)
                    "{{ $query }}"
                @elseif(request()->query('genre'))
                    "{{ request()->query('genre') }}"
                @else
                    "the selected filter"
                @endif.</p>
        @endif
    </div>
</x-app-layout>
