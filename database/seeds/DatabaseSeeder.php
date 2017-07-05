<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('users')->delete();
        $users = array(
                ['name' => 'Yusuf Eka Sayogana', 'email' => 'yusufblegoh@gmail.com', 'password' => bcrypt('secret')],
                ['name' => 'Chris Sevilleja', 'email' => 'chris@scotch.io', 'password' => bcrypt('secret')],
                ['name' => 'Holly Lloyd', 'email' => 'holly@scotch.io', 'password' => bcrypt('secret')],
                ['name' => 'Adnan Kukic', 'email' => 'adnan@scotch.io', 'password' => bcrypt('secret')],
        );
            
        // Loop through each user above and create the record for them in the database
        foreach ($users as $user)
        {
            User::create($user);
        }
        
    }
}
