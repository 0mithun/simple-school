<?php

use Illuminate\Database\Seeder;

class AppSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\AppSetup::class,1)->create();
    }
}
