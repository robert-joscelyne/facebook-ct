<?php

use App\Friend;
use Illuminate\Database\Seeder;

class FriendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Friends Seeder');
        $this->clean();
        $this->populate();
    }

    private function clean()
    {
        $this->command->info('Truncate friends table');
        DB::table('friends')->truncate();
    }

    private function populate()
    {
        $friends = \App\User::whereIn('id', [2, 3])->get();

        foreach ($friends as $friend)
        {
            $this->command->info('Creating Friend record for: ' . $friend->id . ' ' . $friend->name);
            Friend::create([
                'user_id' => 1,
                'friend_id' => $friend->id,
                'status' => 1,
                'confirmed_at' => now()->subDay()
            ]);
        }

    }
}
