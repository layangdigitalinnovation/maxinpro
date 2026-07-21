<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignId('property_type_id')->constrained()->restrictOnDelete();
            $table->foreignId('area_id')->constrained()->restrictOnDelete();
            $table->foreignId('agent_id')->nullable()->constrained()->nullOnDelete();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('price'); // stored in Rupiah (whole number)
            $table->unsignedInteger('land_area')->nullable(); // m2
            $table->unsignedInteger('building_area')->nullable(); // m2
            $table->unsignedTinyInteger('bedrooms')->default(0);
            $table->unsignedTinyInteger('bathrooms')->default(0);
            $table->unsignedTinyInteger('car_ports')->default(0);
            $table->enum('badge', ['Terpopuler', 'Baru', 'Premium'])->nullable();
            $table->enum('status', ['active', 'sold', 'hidden'])->default('active');
            $table->string('cover_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['status', 'published_at']);
            $table->index(['property_type_id', 'area_id']);
            $table->index('price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
