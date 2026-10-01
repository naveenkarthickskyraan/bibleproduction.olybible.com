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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('question_name');
            $table->string('question_content');
            $table->string('question_format_type');
            $table->string('option_format_type');
            $table->text('option_1');
            $table->text('option_2');
            $table->text('option_3');
            $table->text('option_4');
            $table->text('option_5');
            $table->text('option_6');
            $table->string('quiz_answer');
            $table->string('quiz_hint');
            $table->string('quiz_image');
            $table->string('image_type');
            $table->string('quiz_exp');
            $table->string('option_count');
            $table->string('category_id')->nullable();
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
        Schema::dropIfExists('quizzes');
    }
};
