<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create initial roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $agentRole = Role::firstOrCreate(['name' => 'agent', 'guard_name' => 'web']);

        // Migrate existing users based on the string 'role' column
        User::chunk(100, function ($users) use ($adminRole, $agentRole) {
            foreach ($users as $user) {
                if ($user->role === 'admin') {
                    $user->assignRole($adminRole);
                } elseif ($user->role === 'agent') {
                    $user->assignRole($agentRole);
                }
            }
        });

        // Drop the old 'role' column since we now use Spatie roles
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('agent')->after('password');
        });

        // Reverse the user role assignments back to the string column
        User::chunk(100, function ($users) {
            foreach ($users as $user) {
                if ($user->hasRole('admin')) {
                    $user->update(['role' => 'admin']);
                } elseif ($user->hasRole('agent')) {
                    $user->update(['role' => 'agent']);
                }
            }
        });

        // Roles are not deleted automatically as they might have been modified,
        // but typically you don't delete them in down() unless specifically required.
    }
};