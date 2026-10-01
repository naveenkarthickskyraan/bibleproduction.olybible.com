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
        Schema::create('app_infos', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->nullable();
            $table->string('app_description')->nullable();
            $table->string('app_image')->nullable();
            $table->string('image_type')->default(1);
            $table->string('app_type')->default(1);
            $table->string('playstore_url')->nullable();
            $table->string('appstore_url')->nullable();
            $table->string('apple_id')->nullable();
            $table->string('bundle_id')->nullable();
            $table->string('package_name')->nullable();
            $table->string('temp_id')->nullable();
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
        Schema::dropIfExists('app_infos');
    }
};
