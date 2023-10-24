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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('events_registration_id')->nullable();
            $table->foreign('events_registration_id')->references('id')->on('events_registration');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('fish_count');
            $table->string('weight');
            $table->enum('status', ['special', 'reguler']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::table('results', function (Blueprint $table) {
            $table->dropColumn('event_registration_id');
            $table->dropColumn('weight');
            $table->dropColumn('status');
        });    }
};
