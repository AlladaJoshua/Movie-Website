<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tmdb_id')->unsigned();
            $table->string('title', 255)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('tagline')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->text('path_movie')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->date('release_date')->nullable();
            $table->text('overview')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->text('poster_path')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->text('background_path')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->decimal('vote_average', 3, 2)->nullable();
            $table->longText('genre_ids')->charset('utf8mb4')->collation('utf8mb4_bin')->nullable();
            $table->integer('runtime')->unsigned()->nullable();
            $table->longText('subtitle_link')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->integer('vote_count')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
