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
        Schema::create('template_infos', function (Blueprint $table) {
            $table->id();
            $table->string('template_name')->nullable();
            $table->string('template_bible_name')->nullable();
            $table->longtext('dictionary_word_ids')->nullable();
            $table->boolean('is_active')->default(0);
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
        Schema::dropIfExists('template_infos');
    }
};
