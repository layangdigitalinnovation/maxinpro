<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Lower number = shown first (further left on the homepage carousel
            // and higher up on the /project listing page). Admin-controlled via
            // the drag-and-drop "Atur Urutan" screen — see Admin\ProjectController.
            $table->unsignedInteger('priority_order')->default(0)->after('id');

            // Optional type badge (Rumah/Tanah/Ruko/Apartemen) shown on the
            // project card, matching the reference design. Nullable because
            // existing projects won't have one until an admin sets it.
            $table->foreignId('property_type_id')->nullable()->after('developer_id')
                ->constrained()->nullOnDelete();

            $table->index('priority_order');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropConstrainedForeignId('property_type_id');
            $table->dropColumn('priority_order');
        });
    }
};
