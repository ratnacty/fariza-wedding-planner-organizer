<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('whatsapp');
            $table->date('wedding_date');
            $table->string('event_location')->nullable();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete();
            $table->text('message')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->index('wedding_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
