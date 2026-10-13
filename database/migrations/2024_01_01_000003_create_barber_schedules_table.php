<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barber_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barber_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('day_of_week'); // 1=Monday ... 7=Sunday
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('is_day_off')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barber_schedules');
    }
};
