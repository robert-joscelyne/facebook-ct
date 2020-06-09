<?php

use Illuminate\Database\Seeder;
use App\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Post Seeder');
        $this->clean();
        $this->populate();
    }

    private function clean()
    {
        $this->command->info('Truncate posts table');
        DB::table('posts')->truncate();
    }

    private function populate()
    {
        $users = \App\User::get();
        foreach($users as $user)
        {
            $posts = factory(Post::class, 5)->create(
                [
                    'user_id' => $user->id
                ]
            );
        }

    }
}
