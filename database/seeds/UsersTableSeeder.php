<?php

use App\AppSetup;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * @var array
     */

    
    
  
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\User::class,10)->create();
        $settings = AppSetup::create([
            'app_title'    =>   'Simple School',
            'app_description'    =>   'Simple School Management Application',
            'copyright_title'    =>   'copyright@techmithun.com',
            'app_logo'    =>   asset('assets/logo.png'),
            'app_favicon'    =>   asset('assets/logo.png'),
        ]);

       $user = User::create([
        'name' => 'Mithun Halder',
        'email' => 'halderm86@gmail.com',
        'password' =>  bcrypt('123456'),
        'sex'       =>  1,
        'date_of_birth' =>  now(),
        'user_photo'    =>  asset('assets/images/img.jpg'),
        'remember_token' => str_random(10),
     ]);

    }
}
