<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // database/migrations/2023_01_01_create_bible_jobs_table.php
        Schema::create('bible_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_type'); // e.g., 'word_check'
            $table->string('status'); // 'pending', 'running', 'completed', 'failed', 'stopped'
            $table->integer('progress')->default(0);
            $table->string('current_version')->nullable();
            $table->integer('current_verse_count')->default(0);
            $table->integer('total_verses_in_version')->default(0);
            $table->integer('processed_versions')->default(0);
            $table->integer('total_versions')->default(0);
            $table->text('error')->nullable();
            $table->string('pid')->nullable(); // Process ID for stopping
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bible_jobs');
    }
};
