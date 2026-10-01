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
        Schema::create('dictionary_infos', function (Blueprint $table) {
            $table->id();
            $table->string('word')->nullable();
            $table->longtext('description')->nullable();
            $table->string('app_id')->nullable();
            $table->string('table_name')->nullable();
            $table->string('version_id')->nullable();
            $table->string('is_active')->default(0);
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
        Schema::dropIfExists('dictionary_infos');
    }
};
