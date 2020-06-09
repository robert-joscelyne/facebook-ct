<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Post;
use App\Friend;
use App\Http\Resources\Post as PostResource;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $friends = Friend::friendships();

        if ($friends->isEmpty()) {

            return new PostCollection(request()->user()->posts);
        }

        $userIds = $friends->pluck('friend_id');

        return new PostCollection(
            Post::whereIn('user_id', $userIds)
                ->get()
        );
    }

    public function store()
    {

        $data = request()->validate([
            'data.attributes.body' => '',
        ]);

        $post = request()->user()->posts()->create($data['data']['attributes']);

        return new PostResource($post);
    }
}
