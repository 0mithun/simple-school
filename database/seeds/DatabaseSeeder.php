<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(TeacherTableSeeder::class);
        $this->call(ClassModelSeeder::class);

        $this->call(AppSetupSeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(SubjectSeeder::class);

        $this->call(StudentSeeder::class);
        
    }
}
