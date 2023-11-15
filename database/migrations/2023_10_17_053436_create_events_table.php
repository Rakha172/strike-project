<?php

use App\Models\Result;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price');
            $table->string('total_booth');
            $table->string('event_date');
            $table->string('location');
            $table->string('description');
            $table->string('image');
            $table->enum('qualification', [
                'weight',
                'total',
                'special',
                'combined',
                'weight special',
                'weight total
            ',
                'total special'
            ]);
            $table->time('start');
            $table->time('end');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
    public function results()
    {
        return $this->hasMany(Result::class, 'event_id');
    }
};
