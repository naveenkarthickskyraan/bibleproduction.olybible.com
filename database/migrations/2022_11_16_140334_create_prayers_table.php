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
        Schema::create('prayers', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('prayer_title');
            $table->dateTime('prayer_time');
            $table->integer('book_number');
            $table->integer('version_number');
            $table->integer('chapter_number');
            $table->string('prayer_image');
            $table->string('image_type')->default(0);
            $table->string('prayer_url');
            $table->string('prayer_video_url');
            $table->string('video_upload_type');
            $table->string('video_thumb_image');
            $table->boolean('video_thumb_upload_type');
            $table->text('opening_prayer');
            $table->text('closing_prayer');
            $table->string('scripture');
            $table->string('category_id');
            $table->string('admin_id');
            $table->string('deleted_at')->default(0);
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
        Schema::dropIfExists('prayers');
    }
};
