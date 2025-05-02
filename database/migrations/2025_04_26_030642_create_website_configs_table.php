<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsiteConfigsTable extends Migration
{
    public function up()
    {
        Schema::create('website_configs', function (Blueprint $table) {
            $table->id();
            $table->string('website_name');
            $table->text('description');
            $table->text('keywords');
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('sitemap')->nullable();
            $table->enum('website_status', ['active', 'maintenance']);
            $table->enum('website_type', ['store', 'simple', 'product_catalog']);
            $table->text('contact_email');
            $table->text('contact_phone');
            $table->text('address');
            $table->text('business_info');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('website_configs');
    }
}

