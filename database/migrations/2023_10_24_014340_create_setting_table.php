<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('history');
            $table->string('location');
            $table->text('logo');
            $table->string('slogan');
            $table->text('desc');
            $table->string('phone');
            $table->text('email');
            $table->string('sender')->nullable();
            $table->string('endpoint')->nullable();
            $table->string('media_endpoint')->nullable();
            $table->string('api_key')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting');
    }
};
