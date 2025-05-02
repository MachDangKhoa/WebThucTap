<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaintingModelsTable extends Migration
{
    public function up()
    {
        Schema::create('painting_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_train');
            $table->string('model_path');
            $table->boolean('is_active')->default(0); // Trạng thái mô hình, mặc định là 0 (không hoạt động)
            $table->timestamps();
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('painting_models');
    }
}
