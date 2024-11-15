<nav class="top-bar">
    <a href="{{ route('movie.index') }}" class="{{ request()->routeIs('movie.index') ? 'active' : '' }}"><img
            src="{{ asset('assets/JacSine.png') }}" alt=""></a>
    <ul>
        <li><a href="{{ route('movie.index') }}"
                class="{{ request()->routeIs('movie.index') ? 'active' : '' }}">Movies</a></li>
        <li><a href="{{ route('movie.create') }}" class="{{ request()->routeIs('movie.create') ? 'active' : '' }}">Add
                Movie</a></li>
    </ul>
    <div class="input-container" onclick="toggleActive(this)">
        <label for="search">Search</label>
        <input type="text" name="search" id="search" class="hidden-input" />
    </div>
</nav>
