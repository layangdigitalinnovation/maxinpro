<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['titip_properti', 'kpr', 'general'])->default('titip_properti');
            $table->string('name');
            $table->string('phone', 30);
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('property_type_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('expected_price')->nullable();
            $table->text('specification')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['new', 'contacted', 'closed'])->default('new');
            $table->string('source_ip', 45)->nullable();
            $table->timestamps();

            $table->index(['type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
