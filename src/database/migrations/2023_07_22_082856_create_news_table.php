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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->longText('abstract')->nullable();
            $table->longText('details');
            $table->string('source');
            $table->string('type')->nullable();
            $table->text('web_url');
            $table->timestamp('published_at');
            $table->text('img')->nullable();
            $table->string('api_source');
            $table->timestamps();

            $table->fullText(['title'], 'title_fulltext_index');
            $table->fullText(['abstract'], 'abstract_fulltext_index');
            $table->fullText(['details'], 'details_fulltext_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex('news_fulltext_index');
        });

        Schema::dropIfExists('news');
    }
};

