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
        Schema::create('events_registration', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->string('booth')->nullable();
            $table->enum('payment_status', ['waiting', 'payed','attended', 'cancel'])->default('waiting');
            $table->foreignId('payment_types_id')->nullable()->constrained('payment_types')->cascadeOnDelete();
            $table->text('code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events_registration');
    }
};

