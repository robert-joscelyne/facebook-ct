<?php

namespace Tests\Feature;

use App\Friend;
use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RetrievePostsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_can_retrieve_posts()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $anotherUser = factory(User::class)->create();

        $posts = factory(Post::class, 2)->create(
            [
                'user_id' => $anotherUser->id,
            ]
        );

        Friend::create([
            'user_id' => $user->id,
            'friend_id' => $anotherUser->id,
            'confirmed_at' => now(),
            'status' => 1
        ]);

        $response = $this->get('/api/posts');

        $response->assertStatus(200);

        $response->assertJson(
            [
                'data' => [
                    [
                        'data' => [
                            'type' => 'posts',
                            'id' => $posts->last()->id,
                            'attributes' => [
                                'body' => $posts->last()->body,
                                'image' => $posts->last()->image,
                                'posted_at' => $posts->last()->created_at->diffForHumans(),
                            ],
                        ],
                    ],
                    [
                        'data' => [
                            'type' => 'posts',
                            'id' => $posts->first()->id,
                            'attributes' => [
                                'body' => $posts->first()->body,
                                'image' => $posts->first()->image,
                                'posted_at' => $posts->first()->created_at->diffForHumans(),
                            ]
                        ],
                    ]
                ],
                'links' => [
                    'self' => url('/posts'),
                ],
            ]
        );
    }

    /**
     * @test
     */
    public function  a_user_can_only_retrieve_their_posts()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $posts = factory(Post::class)->create();

        $response = $this->get('/api/posts');

        $response->assertStatus(200)
            ->assertExactJson([
               'data' => [],
               'links' => [
                   'self' => url('/posts'),
               ]
            ]);
    }
}
