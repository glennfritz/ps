<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(SequenceSeeder::class);
        $this->call(TermSeeder::class);
        $this->call(RolesPermissionSeeder::class);
        $this->call(UserRole::class);
        $this->call(SectionSeeder::class);
        $this->call(ClassSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(YearSeeder::class);
    }
}
