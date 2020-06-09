<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('User Seeder');
        $this->clean();
        $this->populate();
    }

    private function clean()
    {
        $this->command->info('Truncate users table');
        DB::table('users')->truncate();
    }

    private function populate()
    {
        $primaryUser = factory(User::class, 1)->create(
            [
                'name' => 'Robert Joscelyne',
                'email' => 'robert.joscelyne@gmail.com'
            ]
        );

        $friends = factory(User::class, 5)->create();
    }
}
