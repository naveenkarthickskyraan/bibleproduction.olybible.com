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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('app_id')->nullable();
            $table->unsignedBigInteger('tree_id');
            $table->string('tree_name');
            $table->unsignedBigInteger('starting_point_id');
            $table->string('starting_point_name');
            $table->json('selected_nodes');
            $table->integer('selection_order');
            $table->timestamps();

            $table->index('tree_id');
            $table->index('starting_point_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
