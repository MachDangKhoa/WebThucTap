<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAPIConfigsTable extends Migration
{
    public function up()
    {
        Schema::create('api_configs', function (Blueprint $table) {
            $table->id();
            $table->string('llm_name');
            $table->string('api_key');
            $table->string('model_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('api_configs', function (Blueprint $table) {
            $table->dropColumn('llm_name');
        });
    }
};