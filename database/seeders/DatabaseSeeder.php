<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        // $this->call(WebsiteSettingsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        // $this->call(AdminMenusTableSeeder::class);
        // $this->call(MigrationsTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(SubscriptionPlanSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(ProductSeeder::class);

        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        // Artisan::call('session:clear');
    }
}
